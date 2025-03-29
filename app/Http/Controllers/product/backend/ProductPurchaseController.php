<?php

namespace App\Http\Controllers\product\backend;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use App\Models\ProductPurchasesReturns;
use App\Models\Suppliers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;
use Session;

class ProductPurchaseController extends Controller
{
    protected $module = 'product_purchases';
    public function __construct()
    {
        $listUsers = dropdown(\App\Models\User::orderBy('id', 'asc')->get(), 'Chọn nhân viên', 'id', 'name');
        $dropdown = getFunctions();
        $paymentMethod = config('payment.method');
        View::share(['module' => $this->module, 'listUsers' => $listUsers, 'paymentMethod' => $paymentMethod, 'dropdown' => $dropdown]);
    }
    public function index()
    {
        $listAddress = dropdown(\App\Models\Address::orderBy('active', 'desc')->get(), 'Chi nhánh', 'id', 'title');
        $listSuppliers = dropdown(\App\Models\Suppliers::orderBy('id', 'desc')->get(), 'Nhà cung cấp', 'id', 'title');
        $data = ProductPurchase::orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        return view('product.backend.purchases.index', compact('data', 'listAddress', 'listSuppliers'));
    }


    public function create()
    {
        //Khởi tạo session
        Session::put('cartPurchases', []);
        Session::put('surcharge', []);
        Session::put('discount', []);
        Session::save();
        //end
        $suppliers = \App\Models\Suppliers::orderBy('id', 'desc')->paginate(6);
        $listAddress = \App\Models\Address::select('id', 'title', 'active')->orderBy('active', 'desc')->get();
        $products = \App\Models\Product::select('id', 'title', 'image', 'price_import', 'inventoryQuantity', 'unit')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0])
            ->orderBy('id', 'desc')
            ->with('product_versions')
            ->paginate(10);
        return view('product.backend.purchases.create', compact('suppliers', 'products', 'listAddress'));
    }
    public function store(Request $request)
    {
        //danh sách sản phẩm
        $products = Session::get('cartPurchases');
        $cart = $this->loadDataPurchases($products);
        //danh sách chi phí
        $surcharge = Session::get('surcharge');
        $discount = Session::get('discount');
        if (empty($products)) {
            return redirect()->route('product_purchases.create')->with('error', "Vui lòng chọn sản phẩm vào đơn nhập");
        }
        $request->validate([
            'suppliers_id' => 'required',
        ], [
            'suppliers_id.required' => 'Vui lòng thêm nhà cung cấp!.',
        ]);
        //số tiền thanh toán cho nhà cung cấp
        $price_suppliers = !empty($request->price_suppliers) ? str_replace('.', '', $request->price_suppliers) : 0;
        //tích "Thanh toán với nhà cung cấp"
        $financialStatusValue = $request->financialStatusValue;
        $financialInfo = !empty($request->financialInfo) ? $request->financialInfo : [];
        //tích "Nhập hàng vào kho"
        $receiveStatusValue = $request->receiveStatusValue;
        //tổng tiền
        $price_total = !empty($cart) ? (!empty($cart['total']) ? $cart['total'] : 0) : 0;
        $status = 'active';
        $receiveStatus = 'pending';
        $financialStatus = 'pending';
        //trạng thái
        if (!empty($financialStatusValue) && !empty($receiveStatusValue) && $price_total == $price_suppliers) {
            $status = 'completed';
        }
        //check số tiền thanh toán
        if (!empty($financialStatusValue)) {
            if ($price_total == $price_suppliers) {
                $financialStatus = 'paid';
            } else if ($price_suppliers < $price_total) {
                $financialStatus = 'partially_paid';
            }
        }
        //nhập kho
        if (!empty($receiveStatusValue)) {
            $receiveStatus = 'received';
        }
        $address_id = $request->address_id;
        $_data = array(
            'suppliers_id' => $request->suppliers_id,
            'code' => $request->code,
            'address_id' => $address_id,
            'products' => json_encode($products),
            //THANH TOÁN
            'price_suppliers' => $price_suppliers,
            'price_total' => $price_total,
            //chiết khấu
            'discount' => !empty($discount) ? json_encode($discount) : '',
            'reference' => $request->reference,
            'dueOn' => $request->dueOn,
            'note' => $request->note,
            //chi phí
            'surcharge' => !empty($surcharge) ? json_encode($surcharge) : '',
            'status' => $status,
            'financialStatusValue' => !empty($financialStatusValue) ? $financialStatusValue : 0,
            'financialStatus' => $financialStatus,

            'receiveStatusValue' => !empty($receiveStatusValue) ? $receiveStatusValue : 0,
            'receiveStatus' => $receiveStatus,
            'user_id' => Auth::user()->id,
            'created_at' => Carbon::now()
        );

        $id = \App\Models\ProductPurchase::insertGetId($_data);
        if (!empty($id)) {
            /**
             * Thêm sản phẩm vào bảng product_purchases_items: DONE
             * Cập nhập công nợ của nhà cung cấp: DONE
             * Cập nhập hàng đang về bảng product_stocks cho mỗi vào sản phẩm: trong trường hợp không tích nút kho hàng: DONE
             * Cập nhập số lượng tồn kho vào bảng product_stocks cho mỗi vào sản phẩm: trong trường hợp tích nút kho hàng: DONE
             * Cập nhập vào bảng product_stock_history (lịch sử tồn kho) (trong trường hợp tích nút kho hàng)
             * Tạo phiếu chi (trong trường hợp thanh toán đầy đủ và thanh toán 1 phần)
             */
            /* Thêm sản phẩm vào bảng product_purchases_items */
            // $tmpProducts = [];
            // if (!empty($products)) {
            //     foreach ($products as $key => $item) {
            //         $tmpProducts[] = [
            //             'rowid' => $key,
            //             'product_purchases_id' => $id,
            //             'product_id' => $item['id'],
            //             'product_version' =>  !empty($item['options']['id_version']) ? $item['options']['id_version'] : '',
            //             'quantity' => $item['quantity'] ?? 0,
            //             'quantity_return' => $item['quantity_return'] ?? 0,
            //             'price' => $item['price'] ?? 0,
            //             'price_taxes' => $item['price_taxes'] ?? 0,
            //             'taxes_import' => $item['taxes_import'] ?? 0,
            //             'taxes_type' => $item['taxes_type'] ?? '',
            //             'taxes_value' => $item['taxes_value'] ?? 0,
            //             'created_at' => Carbon::now()
            //         ];
            //     }
            // }
            // if (!empty($tmpProducts)) {
            //     \App\Models\ProductPurchasesItem::insert($tmpProducts);
            // }
            /* Cập nhập công nợ của nhà cung cấp */
            //tích nút "Thanh toán với nhà cung cấp"
            $priceFinancial  = 0;
            if (!empty($financialStatusValue)) {
                //Số tiền thanh toán nhỏ hơn Tổng tiền
                if ($price_suppliers < $price_total) {
                    $detailSuppliers = \App\Models\Suppliers::select('id', 'debt')->find($request->suppliers_id);
                    if (!empty($detailSuppliers)) {
                        $priceFinancial = $price_total - $price_suppliers;
                        \App\Models\Suppliers::where('id', $detailSuppliers->id)->update([
                            'debt' => (!empty($detailSuppliers->debt) ? $detailSuppliers->debt : 0) + $priceFinancial,
                            'updated_at' =>  Carbon::now()
                        ]);
                    }
                }
                //ghi log bảng: product_purchases_financials
                \App\Models\ProductPurchasesFinancial::insertGetId(array(
                    'price' => $price_suppliers,
                    'method' => !empty($financialInfo['method']) ? $financialInfo['method'] : '',
                    'reference' => !empty($financialInfo['reference']) ? $financialInfo['reference'] : '',
                    'product_purchases_id' => $id,
                    'userid_created' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ));
                //thêm mới vào bảng: payment_vouchers
                $code_payment_vouchers = CodeRender('payment_vouchers');
                if (!empty($price_suppliers)) {
                    \App\Models\PaymentVouchers::insertGetId(array(
                        'address_id' => $address_id,
                        'code' => $code_payment_vouchers,
                        'module' => 'product_purchases',
                        'module_id' => $id,
                        'group_id' => 11,
                        'price' => $price_suppliers,
                        'type' => !empty($financialInfo['method']) ? $financialInfo['method'] : '',
                        'reference' => !empty($financialInfo['reference']) ? $financialInfo['reference'] : '',
                        'checked' => 1,
                        'status' => 'completed',
                        'userid_created' => Auth::user()->id,
                        'created_at' => Carbon::now()
                    ));
                }
            } else {
                $detailSuppliers = \App\Models\Suppliers::select('id', 'debt')->find($request->suppliers_id);
                if (!empty($detailSuppliers)) {
                    \App\Models\Suppliers::where('id', $detailSuppliers->id)->update([
                        'debt' => (!empty($detailSuppliers->debt) ? $detailSuppliers->debt : 0) + $price_total,
                        'updated_at' =>  Carbon::now()
                    ]);
                }
            }
            /**END: Cập nhập công nợ của nhà cung cấp */
            /**START: Cập nhập số lượng tồn kho */
            //tích nút: "Nhập hàng vào kho" => Cập nhập số lượng stock bảng "product_stocks"
            if (!empty($receiveStatusValue)) {
                foreach ($products as $item) {
                    $id_version = !empty($item['options']['id_version']) ? $item['options']['id_version'] : '';
                    if (!empty($id_version)) {
                        $queryWhere = ['product_id' => $item['id'], 'product_version_id' => $id_version, 'address_id' => $address_id];
                    } else {
                        $queryWhere = ['product_id' => $item['id'], 'address_id' => $address_id];
                    }
                    $detailStock = \App\Models\ProductStock::select('id', 'value')
                        ->where($queryWhere)
                        ->first();
                    \App\Models\ProductStock::where($queryWhere)
                        ->update([
                            'value' => (int)$detailStock['value'] + (int)$item['quantity'],
                            'updated_at' =>  Carbon::now()
                        ]);
                    //ghi lịch sử
                    \App\Models\ProductStockHistory::insertGetId(array(
                        'product_id' => $item['id'],
                        'product_version_id' => !empty($id_version) ? $id_version : '',
                        'address_id' =>  $address_id,
                        'purchase_id' => $id,
                        'user_id' =>  Auth::user()->id,
                        'quantity' => (int)$item['quantity'],
                        'type' => 'plus',
                        'stock' => (int)$detailStock['value'] + (int)$item['quantity'],
                        'created_at' => Carbon::now(),
                        'note' => 'Nhập hàng - Mã đơn nhập hàng <span class="font-bold text-danger">' . $request->code . '</span>'
                    ));
                }
                \App\Models\ProductPurchase::where('id', '=', $id)->update(array(
                    'created_stock_at' => Carbon::now()
                ));
            } else {
                //tích nút: "Nhập hàng vào kho" => Cập nhập số lượng "hàng đang về"
                foreach ($products as $item) {
                    $id_version = !empty($item['options']['id_version']) ? $item['options']['id_version'] : '';
                    if (!empty($id_version)) {
                        $queryWhere = ['product_id' => $item['id'], 'product_version_id' => $id_version, 'address_id' => $address_id];
                    } else {
                        $queryWhere = ['product_id' => $item['id'], 'address_id' => $address_id];
                    }
                    $detailStock = \App\Models\ProductStock::select('id', 'stockComing')->where($queryWhere)->first();
                    \App\Models\ProductStock::where($queryWhere)->update([
                        'stockComing' => !empty($detailStock['stockComing']) ? (int)$detailStock['stockComing'] : 0 + (int)$item['quantity'],
                        'updated_at' =>  Carbon::now()
                    ]);
                }
            }
            /**END : Cập nhập số lượng tồn kho */
            if (!empty($financialStatusValue) && !empty($receiveStatusValue) && $price_total == $price_suppliers) {
                \App\Models\ProductPurchase::where('id', '=', $id)->update(array(
                    'created_completed_at' => Carbon::now()
                ));
            }

            return redirect()->route('product_purchases.index')->with('success', "Thêm mới đơn nhập hàng thành công");
        }
    }
    //ajax list Nhà cung cấp
    public function ajaxListSuppliers(Request $request)
    {
        $keyword = removeutf8($request->keyword);
        $suppliers =  \App\Models\Suppliers::orderBy('id', 'DESC');
        if (!empty($keyword)) {
            $suppliers =  $suppliers->where('code', 'like', '%' . $keyword . '%')
                ->orWhere('title', 'like', '%' . $keyword . '%')
                ->orWhere('phone', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
        }
        $suppliers =  $suppliers->paginate(6);
        return view('product.backend.purchases.create.suppliers', compact('suppliers'))->render();
    }
    //Ajax List product
    public function ajaxListProducts(Request $request)
    {
        $keyword = $request->keyword;
        $type = $request->type;
        $products =  \App\Models\Product::query()
            ->select('id', 'title', 'image', 'price_import', 'inventoryQuantity', 'unit')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0,])
            ->orderBy('order', 'ASC')
            ->orderBy('id', 'DESC')
            ->with('product_versions');
        if (!empty($keyword)) {
            $products =  $products->where('products.title', 'like', '%' . $keyword . '%');
            $products =  $products->orWhere('products.code', 'like', '%' . $keyword . '%');
        }
        $products =  $products->paginate(10);

        return view('product.backend.purchases.create.' . $type, compact('products'))->render();
    }
    //Thêm sản phẩm
    public function addToCartPurchases(Request $request)
    {
        $cart = Session::get('cartPurchases');
        $quantity = 1;
        $id = $request->id;
        $id_version = $request->id_version;
        $title_version = $request->title_version;
        $type = $request->type;
        $price = $request->price;
        $image = $request->image;
        $unit = !empty($request->unit) ? $request->unit : '';
        $product = \App\Models\Product::select('id', 'title', 'unit', 'code')->with('TaxesRelationships')->find($id);
        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại']);
        }
        //tạo rowid
        $rowid = md5($product->id . $id_version);
        if ($type == 'variable') {
            $getVersionProduct = \App\Models\ProductVersion::where('product_id', $id)->where('id', $id_version)->first();
            if (!$getVersionProduct) {
                return response()->json(['error' => 'Phiên bản sản phẩm không tồn tại']);
            }
        }
        $taxes_import = !empty($product->TaxesRelationships->taxes_import) ? $product->TaxesRelationships->taxes_import : 0;
        $taxes_type = !empty($product->TaxesRelationships->taxes_type) ? $product->TaxesRelationships->taxes_type : '';
        $taxes_value = 0;
        $price_taxes = $price;
        if ($taxes_type == 'tax') {
            $priceProduct = round($quantity * $price) / (1 + ($taxes_import / 100));
            $taxes_value = round(($priceProduct / 100) * $taxes_import);
            $price_taxes = round(($price) / (1 + ($taxes_import / 100)));
        } else if ($taxes_type == 'notax') {
            $taxes_value = round((($quantity * $price) / 100) * $taxes_import);
        }
        if (isset($cart[$rowid])) {
            $cart[$rowid]['quantity'] =  $cart[$rowid]['quantity'] + $quantity;
            $cart[$rowid]['image'] =  $image;
            $cart[$rowid]['price'] = $price;
            $cart[$rowid]['price_taxes'] = $price_taxes;
            $cart[$rowid]['taxes_import'] = $taxes_import;
            $cart[$rowid]['taxes_type'] = $taxes_type;
            $cart[$rowid]['taxes_value'] = $taxes_value;
        } else {
            if ($request->type == 'simple') {
                $cart[$rowid] = [
                    "code" => $product->code,
                    "id" => $product->id,
                    "title" => $product->title,
                    "image" => $image,
                    "quantity" => $quantity,
                    "price" => $price,
                    "unit" => $unit,
                    "price_taxes" => $price_taxes,
                    "taxes_import" => $taxes_import,
                    "taxes_type" => $taxes_type,
                    "taxes_value" => $taxes_value,
                ];
            } else {
                $cart[$rowid] = [
                    "code" => $getVersionProduct->code_version,
                    "id" => $product->id,
                    "title" => $product->title,
                    "image" => $image,
                    "quantity" => $quantity,
                    "price" => $price,
                    "options" => array(
                        'id_version' => $id_version,
                        'title_version' => $title_version,
                    ),
                    "unit" => $unit,
                    "price_taxes" => $price_taxes,
                    "taxes_import" => $taxes_import,
                    "taxes_type" => $taxes_type,
                    "taxes_value" => $taxes_value,
                ];
            }
        }
        Session::put('cartPurchases', $cart);
        Session::save();
        return response()->json($this->loadDataPurchases($cart));
    }
    //Thêm nhiều sản phẩm
    public function ajaxAddToCartModalPopup(Request $request)
    {
        $cart = Session::get('cartPurchases');
        $quantity = 1;
        $sList = !empty($request->sList) ? $request->sList : '';
        if (!empty($sList)) {
            foreach ($sList as $item) {
                $data = json_decode($item, TRUE);
                $id = $data['id'];
                $id_version = !empty($data['id_version']) ? $data['id_version'] : '';
                $title_version = !empty($data['title_version']) ? $data['title_version'] : '';
                $type = $data['type'];
                $price = $data['price'];
                $image = $data['image'];
                $unit = !empty($data['unit']) ? $data['unit'] : '';
                $product = \App\Models\Product::select('id', 'title', 'unit', 'code')->with('TaxesRelationships')->find($id);
                if (!$product) {
                    return response()->json(['error' => 'Sản phẩm không tồn tại']);
                }
                //tạo rowid
                $rowid = md5($product->id . $id_version);
                if ($type == 'variable') {
                    $getVersionProduct = \App\Models\ProductVersion::where('product_id', $id)->where('id', $id_version)->first();
                    if (!$getVersionProduct) {
                        return response()->json(['error' => 'Phiên bản sản phẩm không tồn tại']);
                    }
                }
                $taxes_import = !empty($product->TaxesRelationships->taxes_import) ? $product->TaxesRelationships->taxes_import : 0;
                $taxes_type = !empty($product->TaxesRelationships->taxes_type) ? $product->TaxesRelationships->taxes_type : '';
                $taxes_value = 0;
                $price_taxes = $price;
                if ($taxes_type == 'tax') {
                    $priceProduct = round($quantity * $price) / (1 + ($taxes_import / 100));
                    $taxes_value = round(($priceProduct / 100) * $taxes_import);
                    $price_taxes = round(($price) / (1 + ($taxes_import / 100)));
                } else if ($taxes_type == 'notax') {
                    $taxes_value = round((($quantity * $price) / 100) * $taxes_import);
                }
                if (isset($cart[$rowid])) {
                    $cart[$rowid]['quantity'] =  $cart[$rowid]['quantity'] + $quantity;
                    $cart[$rowid]['image'] =  $image;
                    $cart[$rowid]['price'] = $price;
                    $cart[$rowid]['price_taxes'] = $price_taxes;
                    $cart[$rowid]['taxes_import'] = $taxes_import;
                    $cart[$rowid]['taxes_type'] = $taxes_type;
                    $cart[$rowid]['taxes_value'] = $taxes_value;
                } else {
                    if ($type == 'simple') {
                        $cart[$rowid] = [
                            "code" => $product->code,
                            "id" => $product->id,
                            "title" => $product->title,
                            "image" => $image,
                            "quantity" => $quantity,
                            "price" => $price,
                            "unit" => $unit,
                            "price_taxes" => $price_taxes,
                            "taxes_import" => $taxes_import,
                            "taxes_type" => $taxes_type,
                            "taxes_value" => $taxes_value,
                        ];
                    } else {
                        $cart[$rowid] = [
                            "code" => $getVersionProduct->code_version,
                            "id" => $product->id,
                            "title" => $product->title,
                            "image" => $image,
                            "quantity" => $quantity,
                            "price" => $price,
                            "options" => array(
                                'id_version' => $id_version,
                                'title_version' => $title_version,
                            ),
                            "unit" => $unit,
                            "price_taxes" => $price_taxes,
                            "taxes_import" => $taxes_import,
                            "taxes_type" => $taxes_type,
                            "taxes_value" => $taxes_value,
                        ];
                    }
                }
                Session::put('cartPurchases', $cart);
                Session::save();
            }
        }
        return response()->json($this->loadDataPurchases($cart));
    }
    //cập nhập sản phẩm
    public function ajaxUpdateCartPurchases(Request $request)
    {
        $type = $request->type;
        $rowid = $request->rowid;
        $quantity = $request->quantity;
        $cart = Session::get('cartPurchases');
        if ($type == 'update') {
            if (!empty($rowid) && !empty($quantity)) {
                $cart[$rowid]["quantity"] = $quantity;
                //return
                Session::put('cartPurchases', $cart);
                Session::save();
                return response()->json($this->loadDataPurchases($cart));
            } else {
                return response()->json(['error' => 'Error: Có lỗi xảy ra']);
            }
        }
        if ($type == 'updatePrice') {
            if (!empty($rowid) && !empty($request->price)) {
                $cart[$rowid]["price"] = str_replace('.', '', $request->price);
                $quantity = $cart[$rowid]["quantity"];
                $price = $cart[$rowid]["price"];
                $taxes_import = $cart[$rowid]["taxes_import"];
                if ($cart[$rowid]['taxes_type'] == 'tax') {
                    $priceProduct = round($quantity * $price) / (1 + ($taxes_import / 100));
                    $taxes_value = round(($priceProduct / 100) * $taxes_import);
                    $price_taxes = round(($price) / (1 + ($taxes_import / 100)));
                    $cart[$rowid]["price_taxes"] = $price_taxes;
                    $cart[$rowid]["taxes_value"] = $taxes_value;
                } else {
                    $cart[$rowid]["price_taxes"] = $cart[$rowid]["price"];
                }
                //return
                Session::put('cartPurchases', $cart);
                Session::save();
                return response()->json($this->loadDataPurchases($cart));
            } else {
                return response()->json(['error' => 'Error: Có lỗi xảy ra']);
            }
        } else if ($type == 'delete') {
            if ($rowid) {
                if (isset($cart[$rowid])) {
                    unset($cart[$rowid]);
                    Session::put('cartPurchases', $cart);
                    Session::save();
                    return response()->json($this->loadDataPurchases($cart));
                } else {
                    return response()->json(['error' => 'Error: Có lỗi xảy ra']);
                }
            } else {
                return response()->json(['error' => 'Error: Có lỗi xảy ra']);
            }
        } else {
            return response()->json(['error' => 'Error: Có lỗi xảy ra']);
        }
    }
    //Thêm chiết khấu
    public function addDiscount(Request $request)
    {
        $value = !empty($request->value) ? str_replace('.', '', $request->value) : 0;
        $type = $request->type;
        $priceDiscount = 0;
        $cart = Session::get('cartPurchases');
        if (!empty($type) && !empty($cart)) {
            $taxesArr = [];
            $provisional = 0;
            $tax = 0;
            $total = 0;
            if ($type == 'money' || $type == 'percent') {
                if (!empty($cart)) {
                    foreach ($cart as $key => $item) {
                        $provisional = $provisional + ((int)$item['quantity'] * (float)$item['price_taxes']);
                    }
                    $collectCart = collect($cart)->groupBy('taxes_import')->all();
                    if (!empty($collectCart)) {
                        foreach ($collectCart as $key => $item) {
                            if (!empty($item)) {
                                foreach ($item as $k => $v) {
                                    $taxesArr[$key][] = $v['taxes_value'] * $v['quantity'];
                                }
                            }
                        }
                    }
                }
                //tính tổng VAT
                if (!empty($taxesArr)) {
                    foreach ($taxesArr as $key => $item) {
                        if ($key > 0) {
                            $tax = $tax + collect($item)->sum();
                        }
                    }
                }
                //chi phí
                $surcharge = Session::get('surcharge');
                $priceSurcharge = 0;
                if (!empty($surcharge)) {
                    $priceSurcharge = $surcharge['sum'];
                }
                //tổng tiền
                $total = $provisional + $priceSurcharge + $tax;
                if ($type == 'money') {
                    if ($value > $total) {
                        return response()->json(['error' => 'Giá trị chiết khấu phải <= ' . number_format($total, '0', ',', '.') . 'đ']);
                    } else {
                        $total = $total - $value;
                        $priceDiscount = $value;
                        Session::put('discount', array('type' => $type, 'value' => $value, 'price' => $priceDiscount));
                        Session::save();
                        return response()->json([
                            'total' => $total,
                            'priceDiscount' =>  $priceDiscount,
                        ]);
                    }
                } else if ($type == 'percent') {
                    if ($value <= 100) {
                        $priceDiscount = round(($provisional / 100) * $value);
                        $total = $total - $priceDiscount;
                        Session::put('discount', array('type' => $type, 'value' => $value, 'price' => $priceDiscount));
                        Session::save();
                    } else {
                        return response()->json(['error' => 'Phần trăm chiết khấu phải <= 100']);
                    }
                    return response()->json([
                        'total' => $total,
                        'priceDiscount' => $priceDiscount,
                    ]);
                }
            } else {
                return response()->json(['error' => 'Error: Kiểu chiết khấu không tồn tại']);
            }
        } else {
            return response()->json(['error' => 'Không tồn tại giỏ hàng']);
        }
    }
    //Thêm chi phí
    public function ajaxSaveSessionSurcharge(Request $request)
    {
        $sum = !empty($request->sum) ? $request->sum : 0;
        $title = $request->title;
        $price = $request->price;
        Session::put('surcharge', array('sum' => $sum, 'title' => json_encode($title), 'price' => json_encode($price)));
        Session::save();
        $cart = Session::get('cartPurchases');
        return response()->json($this->loadDataPurchases($cart));
    }
    public function loadDataPurchases($cart =  [], $surchargeSum = 0, $discountSum = 0)
    {
        $taxesArr = [];
        $html =  $htmlVAT = '';
        $total = $tax = $quantity = $provisional = 0;
        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                $quantity = $quantity + (int)$item['quantity'];
                $provisional = $provisional + ((int)$item['quantity'] * (float)$item['price_taxes']);
                // $title_version = !empty($item['options']['title_version']) ? collect(json_decode($item['options']['title_version'], TRUE))->join('', ',') : '';
                $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
                $html .= '<tr class="">';
                $html .= '<td class="" style="text-align:left">';
                $html .= $item['code'];
                $html .= '</td>';
                $html .= '<td class="w-40">';
                $html .= '<div class="flex space-x-2">';
                $html .= '<div class="flex">';
                $html .= '<div class="w-10 h-10 image-fit zoom-in">';
                $html .= '<img alt="' . $item['title'] . '" class="tooltip rounded-full" src="' . $item['image'] . '">';
                $html .= '</div>';
                $html .= '</div>';
                $html .= '<div>';
                $html .= '<a href="javascript:void(0)" class="font-medium whitespace-nowrap">' . $item['title'] . '</a><br><i>' . $title_version . '</i>';
                if ($item['taxes_type'] == 'tax') {
                    $html .= '<div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Giá đã bao gồm thuế(' . $item['taxes_import'] . '%)</div>';
                } else if ($item['taxes_type'] == 'notax') {
                    $html .= '<div class="text-slate-500 text-xs whitespace-nowrap mt-0.5">Giá chưa bao gồm thuế(' . $item['taxes_import'] . '%)</div>';
                }
                $html .= '</div>';
                $html .= '</div>';
                $html .= '</td>';
                $html .= '<td class="text-center">' . $item['unit'] . '</td>';
                $html .= '<td class="text-center">
                            <input type="number" class="form-control js_updateCartPurchase" value="' . $item['quantity'] . '" data-rowid="' . $key . '">
                          </td>';
                $html .= '<td class="w-40 text-center">';
                $html .= '<input type="text" class="form-control int js_updateCartPricePurchase" value="' . number_format($item['price'], '0', ',', '.') . '" data-rowid="' . $key . '">';
                $html .= '</td>';
                $html .= '<td class="table-report__action w-56 text-center">';
                $html .= number_format($item['price'] * $item['quantity'], '0', ',', '.') . 'đ';
                $html .= '</td>';
                $html .= '<td class="table-report__action text-center cursor-pointer html_deletePurchase" >';
                $html .= '<a href="javascript:void(0)" class="js_removeCartPurchase" data-rowid="' . $key . '"><svg viewBox="0 0 20 20" focusable="false" aria-hidden="true" style="fill: red;width:20px;height:20px"> <path d = "M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z" > < /path> </svg></a>';
                $html .= '</td>';
                $html .= '</tr>';
                /**$taxes_value = 0;
                $price_taxes = $item['price'];
                if ($item['taxes_type'] == 'tax') {
                    $priceProduct = round($item['quantity'] * $item['price']) / (1 + ($item['taxes_import'] / 100));
                    $taxes_value = round(($priceProduct / 100) * $item['taxes_import']);
                    $price_taxes = round(($item['price']) / (1 + ($item['taxes_import'] / 100)));
                } else if ($item['taxes_type'] == 'notax') {
                    $taxes_value = round((($item['quantity'] * $item['price']) / 100) * $item['taxes_import']);
                }
                $cart[$key] = collect($item)->put('taxes_value', $taxes_value)->put('price_taxes', $price_taxes)->toArray(); */
            }
            $collectCart = collect($cart)->groupBy('taxes_import')->all();
            if (!empty($collectCart)) {
                foreach ($collectCart as $key => $item) {
                    if (!empty($item)) {
                        foreach ($item as $k => $v) {
                            $taxesArr[$key][] = $v['taxes_value'] * $v['quantity'];
                        }
                    }
                }
            }
        }
        if (!empty($taxesArr)) {
            foreach ($taxesArr as $key => $item) {
                if ($key > 0) {
                    $tax = $tax + collect($item)->sum();
                    $htmlVAT .= ' <div class="flex justify-between p-2">';
                    $htmlVAT .= '<span class="font-bold flex-1 text-right text-danger">VAT(' . $key . '%)</span>';
                    $htmlVAT .= '<span class="text-right w-32">' . number_format(collect($item)->sum(), '0', ',', '.') . 'đ</span>';
                    $htmlVAT .= '</div>';
                }
            }
        }
        //chiết khấu
        $priceDiscount = 0;
        if (!empty($discountSum)) {
            $priceDiscount = !empty($discountSum) ? (float)$discountSum : 0;
        } else {
            $discount = Session::get('discount');
            if (!empty($discount)) {
                if ($discount['type'] == 'percent') {
                    $priceDiscount = !empty($discount['value']) ? $provisional / 100 * $discount['value'] : 0;
                } else if ($discount['type'] == 'money') {
                    $priceDiscount = !empty($discount) ? (!empty($discount['value']) ? (float)$discount['value'] : 0) : 0;
                }
            }
        }
        //chi phí
        $surcharge = Session::get('surcharge');
        $priceSurcharge = 0;
        if (!empty($surcharge)) {
            $priceSurcharge = $surcharge['sum'];
        } else {
            $priceSurcharge = $surchargeSum;
        }
        //tổng tiền
        $total = $provisional + $priceSurcharge + $tax - $priceDiscount;
        return [
            'cart' => $cart,
            'html' => $html,
            'htmlVAT' => $htmlVAT,
            'quantity' => $quantity,
            'provisional' => $provisional,
            'priceDiscount' => $priceDiscount,
            'priceSurcharge' => $priceSurcharge,
            'price_tax' => $tax,
            'total' => $total,
        ];
    }
    public function validateForm(Request $request)
    {
        $products = Session::get('cartPurchases');
        $cart = $this->loadDataPurchases($products);
        $price_total = !empty($cart) ? (!empty($cart['total']) ? $cart['total'] : 0) : 0;
        if (empty($products)) {
            return response()->json(['error' => "Vui lòng chọn sản phẩm vào đơn nhập"]);
        }
        $validator = Validator::make($request->all(), [
            'suppliers_id' => 'required',
        ], [
            'suppliers_id.required' => 'Vui lòng thêm nhà cung cấp!.',
        ]);

        if ($validator->passes()) {
            return response()->json(['error' => '']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    //blade: show
    public function show($id)
    {
        $detail = ProductPurchase::with(['product_purchases_financials', 'product_purchases_returns', 'address', 'suppliers'])->find($id);
        if (empty($detail)) {
            return redirect()->route('product_purchases.index')->with('error', "Đơn nhập hàng không tồn tại");
        }
        $surcharge = json_decode($detail->surcharge, TRUE);
        $discount = json_decode($detail->discount, TRUE);
        $products = $this->loadDataPurchases(
            json_decode($detail->products, TRUE),
            !empty($surcharge) ? (!empty($surcharge['sum']) ? str_replace('.', '', $surcharge['sum']) : 0) : 0,
            !empty($discount) ? (!empty($discount['price']) ? str_replace('.', '', $discount['price']) : 0) : 0,
        );
        $price = $detail->price_total - $detail->product_purchases_financials->sum('price');
        return view('product.backend.purchases.show', compact('detail', 'products', 'price'));
    }
    //Thanh toán cho nhà cung cấp - blade: show
    public function storeFinancials(Request $request)
    {
        $product_purchases_id = $request->product_purchases_id;
        $detail = ProductPurchase::with('product_purchases_financials')->find($product_purchases_id);
        if (empty($detail)) {
            return response()->json(['error' => 'Đơn nhập hàng không tồn tại']);
        }
        $priceCheck = $detail->price_total - $detail->product_purchases_financials->sum('price');
        $price = !empty($request->price) ? str_replace('.', '', $request->price) : 0;
        if (empty($price)) {
            return response()->json(['error' => 'Có lỗi xảy ra vui lòng thử lại']);
        }
        if ($price > $priceCheck) {
            return response()->json(['error' => 'Số tiền thanh toán lớn số tiền phải trả']);
        }
        $validator = Validator::make($request->all(), [
            'method' => 'required',
            'price' => 'required',
        ], [
            'method.required' => 'Phương thức thanh toán là trường bắt buộc.',
            'price.required' => 'Số tiền thanh toán là trường bắt buộc.',
        ]);
        if ($validator->passes()) {
            $id = \App\Models\ProductPurchasesFinancial::insertGetId([
                'method' => $request->method,
                'price' => $price,
                'reference' => $request->reference,
                'product_purchases_id' => $request->product_purchases_id,
                'userid_created' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                //thêm phiếu chi
                \App\Models\PaymentVouchers::insertGetId(array(
                    'address_id' => $detail->address_id,
                    'code' => CodeRender('payment_vouchers'),
                    'module' => 'product_purchases',
                    'module_id' => $detail->id,
                    'group_id' => 11,
                    'price' => $price,
                    'type' => $request->method,
                    'reference' => $request->reference,
                    'checked' => 1,
                    'status' => 'completed',
                    'userid_created' => Auth::user()->id,
                    'created_at' => Carbon::now()
                ));
                //end
                //tính toán và cập nhập trạng thái
                //check nợ
                $price_debt = $detail->product_purchases_financials->sum('price') + $price;
                if ($price_debt == $detail->price_total) {
                    //Trạng thái nhập kho: Nếu trạng thái nhập kho 'Đã nhập hàng' thì cập nhập trạng thái đơn nhập 'Hoàn thành'
                    if ($detail->receiveStatusValue == 1 && $detail->receiveStatus == 'received') {
                        \App\Models\ProductPurchase::where('id', '=', $detail->id)->update(array(
                            'financialStatus' => 'paid', //Trạng thái: Đã thanh toán
                            'financialStatusValue' => 1, //Thanh toán với nhà cung cấp
                            'created_completed_at' => Carbon::now(),
                            'status' => 'completed',
                        ));
                    } else {
                        \App\Models\ProductPurchase::where('id', '=', $detail->id)->update(array(
                            'financialStatus' => 'paid', //Trạng thái: Đã thanh toán
                            'financialStatusValue' => 1, //Thanh toán với nhà cung cấp
                        ));
                    }
                } else {
                    \App\Models\ProductPurchase::where('id', '=', $detail->id)->update(array(
                        'financialStatus' => 'partially_paid', //Trạng thái: Thanh toán một phần
                    ));
                }
                //trừ công nợ của nhà cung cấp
                $detailSuppliers = \App\Models\Suppliers::select('id', 'debt')->find($detail->suppliers_id);
                if (!empty($detailSuppliers)) {
                    \App\Models\Suppliers::where('id', $detailSuppliers->id)->update([
                        'debt' => (!empty($detailSuppliers->debt) ? $detailSuppliers->debt : 0) - $price,
                        'updated_at' =>  Carbon::now()
                    ]);
                }
                //end
                return response()->json(['success' => 'Thanh toán thành công']);
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra vui lòng thử lại']);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    //Nhập kho - blade: show
    public function storeStocks(Request $request)
    {
        $id = $request->id;
        $detail = ProductPurchase::with('product_purchases_financials')->find($id);
        if (empty($detail)) {
            return response()->json(['error' => 'Đơn nhập hàng không tồn tại']);
        }
        $discount = json_decode($detail->discount, TRUE);
        $surcharge = json_decode($detail->surcharge, TRUE);
        $discount = json_decode($detail->discount, TRUE);
        $request = array(
            'discountValue' =>  !empty($discount['value']) ? $discount['value'] : 0,
            'discountType' =>  !empty($discount['type']) ? $discount['type'] : '',
        );
        $products = $this->loadDataPurchases(
            json_decode($detail->products, TRUE),
            !empty($surcharge) ? (!empty($surcharge['sum']) ? str_replace('.', '', $surcharge['sum']) : 0) : 0,
            !empty($discount) ? (!empty($discount['price']) ? str_replace('.', '', $discount['price']) : 0) : 0,
        );
        $address_id = $detail->address_id;
        if (!empty($products['cart'])) {
            //cập nhập vào bảng product_stocks
            foreach ($products['cart'] as $item) {
                $id_version = !empty($item['options']['id_version']) ? $item['options']['id_version'] : '';
                $queryWhere =  !empty($id_version) ? ['product_id' => $item['id'], 'product_version_id' => $id_version, 'address_id' => $address_id] : ['product_id' => $item['id'], 'address_id' => $address_id];
                $detailStock = \App\Models\ProductStock::select('id', 'value', 'stockComing')
                    ->where($queryWhere)
                    ->first();
                \App\Models\ProductStock::where($queryWhere)
                    ->update([
                        'value' => (int)(!empty($detailStock['value']) ? $detailStock['value'] : 0) + (int)$item['quantity'],
                        'stockComing' => (int)(!empty($detailStock['stockComing']) ? $detailStock['stockComing'] : 0) - (int)$item['quantity'],
                        'updated_at' =>  Carbon::now()
                    ]);
                //ghi lịch sử
                \App\Models\ProductStockHistory::insertGetId(array(
                    'product_id' => $item['id'],
                    'product_version_id' => !empty($id_version) ? $id_version : '',
                    'address_id' =>  $address_id,
                    'purchase_id' => $id,
                    'user_id' =>  Auth::user()->id,
                    'quantity' => (int)$item['quantity'],
                    'type' => 'plus',
                    'stock' => (int)(!empty($detailStock['value']) ? $detailStock['value'] : 0) + (int)$item['quantity'],
                    'created_at' => Carbon::now(),
                    'note' => 'Nhập hàng - Mã đơn nhập hàng <span class="font-bold text-danger">' . $detail->code . '</span>'
                ));
            }
            $price_debt = $detail->product_purchases_financials->sum('price');
            if ($price_debt == $detail->price_total) {
                \App\Models\ProductPurchase::where('id', '=', $id)->update(array(
                    'created_stock_at' => Carbon::now(),
                    'created_completed_at' => Carbon::now(),
                    'receiveStatusValue' => 1,
                    'receiveStatus' => 'received',
                    'status' => 'completed',
                ));
            } else {
                \App\Models\ProductPurchase::where('id', '=', $id)->update(array(
                    'created_stock_at' => Carbon::now(),
                    'receiveStatusValue' => 1,
                    'receiveStatus' => 'received'
                ));
            }

            return response()->json(['success' => 'Nhập hàng thành công']);
        } else {
            return response()->json(['error' => 'Đơn nhập hàng không tồn tại']);
        }
    }
    public function return_index(Request $request)
    {
        $listAddress = dropdown(\App\Models\Address::orderBy('active', 'desc')->get(), 'Chi nhánh', 'id', 'title');
        $listSuppliers = dropdown(\App\Models\Suppliers::orderBy('id', 'desc')->get(), 'Nhà cung cấp', 'id', 'title');
        $keyword = $request->keyword;
        $date = $request->date;
        $user_id = $request->user_id;
        $user_id = $request->user_id;
        $address_id = $request->address_id;
        $suppliers_id = $request->suppliers_id;

        $data = ProductPurchasesReturns::orderBy('product_purchases_returns.id', 'desc')
            ->select('product_purchases_returns.id', 'product_purchases_returns.product_purchases_id', 'product_purchases_returns.created_at', 'addresses.title as address_title', 'suppliers.title as suppliers', 'product_purchases_returns.quantity', 'product_purchases_returns.price_total', 'product_purchases.code', 'users.name');
        $data = $data->join('product_purchases', 'product_purchases.id', "=", 'product_purchases_returns.product_purchases_id');
        $data = $data->join('users', 'users.id', "=", 'product_purchases_returns.userid_created');
        $data = $data->join('addresses', 'addresses.id', "=", 'product_purchases.address_id');
        $data = $data->join('suppliers', 'suppliers.id', "=", 'product_purchases.suppliers_id');
        if (!empty($keyword)) {
            $data =  $data->where('product_purchases.code', 'like', '%' . $keyword . '%')
                ->orWhere('suppliers.title', 'like', '%' . $keyword . '%')
                ->orWhere('suppliers.phone', 'like', '%' . $keyword . '%')
                ->orWhere('suppliers.email', 'like', '%' . $keyword . '%');
        }
        if (is($date)) {
            $date =  explode(' to ', $date);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('created_at', '>=', $date_start)->where('created_at', '<=', $date_end);
            }
        }
        if (!empty($user_id)) {
            $data = $data->where('product_purchases_returns.userid_created', $user_id);
        }
        if (!empty($address_id)) {
            $data = $data->where('product_purchases.address_id', $address_id);
        }
        if (!empty($suppliers_id)) {
            $data = $data->where('product_purchases.suppliers_id', $suppliers_id);
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($date)) {
            $data->appends(['date' => $date]);
        }
        if (is($user_id)) {
            $data->appends(['user_id' => $user_id]);
        }
        if (is($address_id)) {
            $data->appends(['keyword' => $address_id]);
        }
        if (is($suppliers_id)) {
            $data->appends(['suppliers_id' => $suppliers_id]);
        }
        return view('product.backend.purchases.return.index', compact('data', 'listAddress', 'listSuppliers'));
    }
    public function return_show($id)
    {
        $detail = ProductPurchasesReturns::select(
            'product_purchases_returns.*',
            'product_purchases.code',
            'addresses.title as address_title',
            'suppliers.title as suppliers_title',
            'suppliers.debt as suppliers_debt',
            'suppliers.code as suppliers_code',
            'suppliers.phone as suppliers_phone',
            'suppliers.email as suppliers_email',
            'suppliers.address as suppliers_address',
        )
            ->join('product_purchases', 'product_purchases.id', "=", 'product_purchases_returns.product_purchases_id')
            ->join('addresses', 'addresses.id', "=", 'product_purchases.address_id')
            ->join('suppliers', 'suppliers.id', "=", 'product_purchases.suppliers_id')
            ->find($id);
        if (empty($detail)) {
            return redirect()->route('product_purchases.return_index')->with('error', "Đơn hàng hoàn trả không tồn tại");
        }
        return view('product.backend.purchases.return.show', compact('detail'));
    }
    public function return_create($id)
    {
        $detail = ProductPurchase::where('receiveStatusValue', 1)->where('receiveStatus', '!=', 'returned')
            ->with(['product_purchases_financials', 'product_purchases_returns'])
            ->find($id);
        if (empty($detail)) {
            return redirect()->route('product_purchases.show', ['id' => $id])->with('error', "Có lỗi xảy ra");
        }
        $discount = json_decode($detail->discount, TRUE);
        $surcharge = json_decode($detail->surcharge, TRUE);
        $products = $this->loadDataPurchases(
            json_decode($detail->products, TRUE),
            !empty($surcharge) ? (!empty($surcharge['sum']) ? str_replace('.', '', $surcharge['sum']) : 0) : 0,
            !empty($discount) ? (!empty($discount['price']) ? str_replace('.', '', $discount['price']) : 0) : 0,
        );
        $price = $detail->price_total - $detail->product_purchases_financials->sum('price');
        $quantityReturns = [];
        if (!empty($detail->product_purchases_returns)) {
            foreach ($detail->product_purchases_returns as $item) {
                $prds = !empty($item['products']) ? json_decode($item['products'], TRUE) : [];
                if (!empty($prds)) {
                    foreach ($prds as $key => $val) {
                        $quantityReturns[$key] = (!empty($quantityReturns[$key]) ? $quantityReturns[$key] : 0) + (!empty($val['quantity_return']) ? $val['quantity_return'] : 0);
                    }
                }
            }
        }

        return view('product.backend.purchases.return.create', compact('detail', 'products', 'price', 'quantityReturns'));
    }
    public function return_store(Request $request, $id)
    {
        //lưu vào bảng phiếu thu receipt_vouchers
        //chuyển trạng thái "receiveStatus" product_purchases: 'partially_returned' => 'Hoàn trả một phần' hoặc 'returned' => 'Hoàn trả toàn bộ'
        //Cập nhập lại trường "products" product_purchases: Hoàn hàng 1 phần hoặc hoàn hàng toàn bộ
        //Cập nhập lại số lượng tồn kho: product_stocks
        //Lưu lịch sủ tồn kho: product_stock_histories
        $detail = ProductPurchase::where('receiveStatusValue', 1)->where('receiveStatus', '!=', 'returned')->with(['product_purchases_financials', 'product_purchases_returns'])->find($id);
        if (empty($detail)) {
            return redirect()->route('product_purchases.index')->with('error', "Đơn nhập hàng không tồn tại");
        }
        $discount = json_decode($detail->discount, TRUE);
        $surcharge = json_decode($detail->surcharge, TRUE);
        $pds = json_decode($detail->products, TRUE);
        $products = $this->loadDataPurchases(
            json_decode($detail->products, TRUE),
            !empty($surcharge) ? (!empty($surcharge['sum']) ? str_replace('.', '', $surcharge['sum']) : 0) : 0,
            !empty($discount) ? (!empty($discount['price']) ? str_replace('.', '', $discount['price']) : 0) : 0,
        );
        $quantity = $request->quantity;
        $cart = $quantityReturns = [];
        $totalItem = $totalVAT = $totalPrice = $valuePriceDiscount = $valuePriceSurcharge = $priceReturn = 0;
        //lấy tổng số lượng đã hoàn
        if (!empty($detail->product_purchases_returns)) {
            foreach ($detail->product_purchases_returns as $item) {
                $prds = !empty($item['products']) ? json_decode($item['products'], TRUE) : [];
                if (!empty($prds)) {
                    foreach ($prds as $key => $val) {
                        $quantityReturns[$key] = (!empty($quantityReturns[$key]) ? $quantityReturns[$key] : 0) + (!empty($val['quantity_return']) ? $val['quantity_return'] : 0);
                    }
                }
            }
        }
        //end
        $receiveStatus = 'returned';
        if (!empty($pds)) {
            foreach ($pds as $key => $item) {
                $q = $quantity[$key];
                $quantityCheck = $quantity[$key] + (!empty($quantityReturns[$key]) ? $quantityReturns[$key] : 0);
                if ($quantityCheck > $item['quantity']) {
                    return redirect()->route('product_purchases.returns', ['id' => $detail->id])->with('error', "Có lỗi xảy ra");
                }
                //check trạng thái "receiveStatus" product_purchases
                if ($quantityCheck < $item['quantity']) {
                    $receiveStatus = 'partially_returned';
                }
                //end
                $vat = $item['taxes_value'];
                $totalVAT = $totalVAT + $vat * $q;
                $totalItem = $totalItem + $q;
                $totalPrice = $totalPrice + ($q * $item['price_taxes']);
                $cart[$key] = collect($item)->put('quantity_return', $q);
            }
        }

        $priceDiscount = !empty($products['priceDiscount']) ? $products['priceDiscount'] : 0;
        $priceSurcharge = !empty($products['priceSurcharge']) ? $products['priceSurcharge'] : 0;
        $provisional = !empty($products['provisional']) ? $products['provisional'] : 0; // giá tạm tính
        //chiết khấu
        $valuePriceDiscount = !empty($priceDiscount) ? $totalPrice / ($provisional / $priceDiscount) : $totalPrice / $provisional;
        //chiết khấu
        $valuePriceSurcharge = !empty($priceSurcharge) ?  $totalPrice / ($provisional / $priceSurcharge) : $totalPrice / $provisional;
        $priceReturn = $totalPrice + $valuePriceSurcharge + $totalVAT - $valuePriceDiscount;
        /**Insert bảng: product_purchases_returns */
        $idr = \App\Models\ProductPurchasesReturns::insertGetId(array(
            'product_purchases_id' => $id,
            'quantity' => $totalItem,
            'price_total' => $priceReturn,
            'price_provisional' => $provisional,
            'price_total_vat' => $totalVAT,
            'products' => json_encode($cart),
            'price_discount' => $valuePriceDiscount,
            'price_surcharge' => $valuePriceSurcharge,
            'reference' => !empty($request->reference) ? $request->reference : "",
            'method' => !empty($request->method) ? $request->method : "",
            'note' => !empty($request->note) ? $request->note : "",
            'userid_created' =>  Auth::user()->id,
            'created_at' => Carbon::now()
        ));
        /*end*/
        if ($idr > 0) {
            /*lưu vào bảng phiếu thu receipt_vouchers*/
            \App\Models\ReceiptVouchers::insertGetId(array(
                'address_id' => $detail->address_id,
                'code' => CodeRender('receipt_vouchers'),
                'module' => 'product_purchases',
                'module_id' => $detail->id,
                'group_id' => 11,
                'price' => $priceReturn,
                'reference' => !empty($request->reference) ? $request->reference : "",
                'type' => !empty($request->method) ? $request->method : "",
                'checked' => 1,
                'status' => 'completed',
                'userid_created' => Auth::user()->id,
                'created_at' => Carbon::now()
            ));
            /*end*/
            /**
             * chuyển trạng thái "receiveStatus" product_purchases: 'partially_returned' => 'Hoàn trả một phần' hoặc 'returned' => 'Hoàn trả toàn bộ'
             */
            \App\Models\ProductPurchase::where('id', '=', $detail->id)->update(array(
                'receiveStatus' => $receiveStatus,
                // 'products' => json_encode($cart)
            ));
            /*end*/
            /**
             *Cập nhập lại số lượng tồn kho: product_stocks
             *Lưu lịch sủ tồn kho: product_stock_histories
             */
            $address_id = $detail->address_id;
            foreach ($cart as $item) {
                $id_version = !empty($item['options']['id_version']) ? $item['options']['id_version'] : '';
                $queryWhere = !empty($id_version) ? ['product_id' => $item['id'], 'product_version_id' => $id_version, 'address_id' => $address_id] : ['product_id' => $item['id'], 'address_id' => $address_id];
                $detailStock = \App\Models\ProductStock::select('id', 'value', 'stockComing')->where($queryWhere)->first();
                \App\Models\ProductStock::where($queryWhere)->update([
                    'value' => (int)(!empty($detailStock['value']) ? $detailStock['value'] : 0) - (int)$item['quantity_return'], /*Số lượng tồn kho -  số lượng hoàn trả */
                    'updated_at' =>  Carbon::now()
                ]);
                //ghi lịch sử
                \App\Models\ProductStockHistory::insertGetId(array(
                    'product_id' => $item['id'],
                    'product_version_id' => !empty($id_version) ? $id_version : '',
                    'address_id' =>  $address_id,
                    'purchase_id' => $id,
                    'quantity' => (int)$item['quantity_return'],
                    'type' => 'minus',
                    'stock' => (int)(!empty($detailStock['value']) ? $detailStock['value'] : 0) - (int)$item['quantity_return'],
                    'user_id' =>  Auth::user()->id,
                    'created_at' => Carbon::now(),
                    'note' => 'Hoàn trả - Mã đơn nhập hàng <span class="font-bold text-danger">' . $detail->code . '</span>'
                ));
            }
            /*end*/
            return redirect()->route('product_purchases.show', ['id' => $id])->with('success', "Hoàn trả đơn hàng thành công");
        }
    }
}
