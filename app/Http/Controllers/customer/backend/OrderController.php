<?php

namespace App\Http\Controllers\customer\backend;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $table = 'customers';

    public function orders(Request $request, $id)
    {
        $module = $this->table;
        $detail  = Customer::find($id);
        if (!isset($detail)) {
            return redirect()->route('customers.index')->with('error', "Thành viên không tồn tại");
        }
        //xóa session cart
        $remove = $request->remove;
        if (!empty($remove)) {
            Session::forget('cartCopyAdmin' . $remove);
        }
        //end
        $data = \App\Models\Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'customerid' => $id])->orderBy('id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->where('code', 'like', '%' . $request->keyword . '%')
                ->orWhere('fullname', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%');
        }
        if (is($request->status)) {
            $data =  $data->where('status', $request->status);
        }
        if (is($request->payment)) {
            $data =  $data->where('payment', $request->payment);
        }
        $date_start = $request->date_start;
        $date_end = $request->date_end;

        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('created_at', '>=', $date_start . ' 00:00:00')->where('created_at', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('created_at', '>=', $date_end . ' 00:00:00')->where('created_at', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('created_at', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('created_at', '>=', $date_start . ' 00:00:00')->where('created_at', '<=', $date_end . ' 23:59:59');
            }
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->payment)) {
            $data->appends(['payment' => $request->payment]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        return view('customer.backend.order.index', compact('module', 'data', 'detail'));
    }
    public function create($id, $orderID)
    {
        $module = $this->table;
        $detail  = Customer::find($id);
        if (!isset($detail)) {
            return redirect()->route('customers.index')->with('error', "Thành viên không tồn tại");
        }
        $detailOrder = \App\Models\Order::with(['city_name', 'district_name', 'ward_name', 'order_returns'])->find($orderID);
        if (!isset($detailOrder)) {
            return redirect()->route('customers.index')->with('error', "Đơn hàng không tồn tại");
        }
        //Tạo session
        $cartCopy = Session::get('cartCopyAdmin' . $detailOrder->id);
        if (empty($cartCopy)) {
            Session::put('cartCopyAdmin' . $detailOrder->id, json_decode($detailOrder->cart, TRUE));
            Session::save();
        }
        $cart = !empty($cartCopy) ? $cartCopy : json_decode($detailOrder->cart, TRUE);
        //end
        $products = \App\Models\Product::where(['alanguage' => config('app.locale'), 'publish' => 0])
            ->orderBy('id', 'desc')
            ->with('product_versions')
            ->paginate(20);
        //Lấy Tỉnh/Thành phố,....
        $listCity = dropdown(\App\Models\VNCity::orderBy('name', 'asc')->get(), 'Tỉnh/Thành Phố', 'id', 'name');
        $listDistrict = dropdown(\App\Models\VNDistrict::where('ProvinceID', $detailOrder->city_id)->orderBy('name', 'asc')->get(), 'Quận/Huyện', 'id', 'name');
        $listWard = dropdown(\App\Models\VNWard::where('DistrictID', $detailOrder->district_id)->orderBy('name', 'asc')->get(), 'Phường/Xã', 'id', 'name');
        //lấy phí vận chuyển
        $getFeeShip = getFeeShip($detailOrder->city_id, $detailOrder->district_id);
        $payments = \App\Models\orderConfig::select('id', 'title', 'description', 'image', 'keyword')->where('publish', 0)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('customer.backend.order.create', compact('module', 'detailOrder', 'detail', 'cart', 'products', 'listCity', 'listDistrict', 'listWard', 'getFeeShip', 'payments'));
    }
    public function ajaxListProduct(Request $request)
    {
        $keyword = removeutf8($request->keyword);
        $products =  \App\Models\Product::query()
            ->where('alanguage', config('app.locale'))
            ->orderBy('order', 'ASC')
            ->orderBy('id', 'DESC')->with('product_versions');
        if (!empty($keyword)) {
            $products =  $products->where('products.title', 'like', '%' . $keyword . '%');
            $products =  $products->orWhere('products.code', 'like', '%' . $keyword . '%');
        }
        $products =  $products->paginate(20);
        return view('customer.frontend.manager.order.dataProduct', compact('products'))->render();
    }
    public function addToCart(Request $request)
    {
        $alert = array(
            'error' => '',
            'message' => '',
            'total' => 0,
            'total_coupon' => 0,
            'total_items' => 0,
            'coupon_price' => 0
        );
        $html = '';
        $provisional = 0;
        $cart = Session::get('cartCopyAdmin' . $request->idCopyCart);
        $quantity = 1;
        $id = $request->id;
        $idVersion = $request->idVersion;
        $titleVersion = $request->titleVersion;
        $titleVersion = collect(json_decode($request->titleVersion, TRUE))->join(',', '');
        $product = \App\Models\Product::select('id', 'title', 'slug', 'price', 'price_sale', 'price_contact', 'unit', 'inventory', 'inventoryPolicy', 'inventoryQuantity', 'catalogue_id', 'image', 'ships')
            ->with('product_versions')->find($id);
        if (!$product) {
            $alert['error'] = 'Sản phẩm không tồn tại';
            return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
        }
        if (count($product->product_versions) > 0) {
            if (!empty($idVersion)) {
                $productVersion = \App\Models\ProductVersion::where('product_id', $id)->where('id_version', $idVersion)->first();
                if (!$productVersion) {
                    $alert['error'] = 'Phiên bản sản phẩm không tồn tại';
                    return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                }
                //check stock
                $checkCartVariable = checkCart($productVersion, $quantity);
                if (!empty($checkCartVariable['status'])) {
                    $alert['error'] = $checkCartVariable['message'];
                    return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                }
                //end
                $ships = array(
                    'weight' => !empty($productVersion['_ships_weight']) ? $productVersion['_ships_weight'] : 200,
                    'length' => !empty($productVersion['_ships_length']) ? $productVersion['_ships_length'] : 1,
                    'width' => !empty($productVersion['_ships_width']) ? $productVersion['_ships_width'] : 2,
                    'height' => !empty($productVersion['_ships_height']) ? $productVersion['_ships_height'] : 3,
                );
                $priceProduct = getPrice(array('price' => $productVersion['price_version'], 'price_sale' => $productVersion['price_sale_version'], 'price_contact' =>
                0));
            } else {
                $alert['error'] = 'Chọn các tùy chọn cho sản phẩm trước khi cho sản phẩm vào giỏ hàng của bạn.';
                return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
            }
        } else {
            //check stock
            $checkCartVariable = checkCart($product, $quantity, 'simple');
            if (!empty($checkCartVariable['status'])) {
                $alert['error'] = $checkCartVariable['message'];
                return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
            }
            //end
            $ships = json_decode($product->ships, TRUE);
            $priceProduct = getPrice(array('price' => $product['price'], 'price_sale' => $product['price_sale'], 'price_contact' =>
            $product['price_contact']));
        }
        //tạo rowid
        $rowid = md5($product->id . $titleVersion);
        if (isset($cart[$rowid])) {
            $quantity = $cart[$rowid]['quantity'] + 1;

            if (count($product->product_versions) > 0) {
                if (!empty($idVersion)) {
                    $productVersion = \App\Models\ProductVersion::where('product_id', $id)->where('id_version', $idVersion)->first();
                    if (!$productVersion) {
                        $alert['error'] = "Phiên bản sản phẩm không tồn tại";
                        return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                    }
                    //check cart
                    $checkCartVariable = checkCart($productVersion, $quantity);
                    if (!empty($checkCartVariable['status'])) {
                        $alert['error'] = $checkCartVariable['message'];
                        return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                    }
                    //end
                } else {
                    $alert['error'] = 'Chọn các tùy chọn cho sản phẩm trước khi cho sản phẩm vào giỏ hàng của bạn.';
                    return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                }
            } else {
                //check stock
                $checkCartVariable = checkCart($product, $quantity, 'simple');
                if (!empty($checkCartVariable['status'])) {
                    $alert['error'] = $checkCartVariable['message'];
                    return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                }
                //end
            }
            //update
            $cart[$rowid]['quantity'] =  $quantity;
            $cart[$rowid]['image'] =  !empty($request->image) ? $request->image : $product->image;
            $cart[$rowid]['price'] = $priceProduct['price_final_none_format'];
            $cart[$rowid]['ships'] = $ships;
            $cart[$rowid]['unit'] = $product->unit;
        } else {
            if ($request->type == 'simple') {
                $cart[$rowid] = [
                    "id" => $product->id,
                    "title" => $product->title,
                    "slug" => $product->slug,
                    "image" => $product->image,
                    "quantity" => 1,
                    "price" => $priceProduct['price_final_none_format'],
                    "ships" => $ships,
                    "unit" => $product->unit
                ];
            } else {
                $cart[$rowid] = [
                    "id" => $product->id,
                    "title" => $product->title,
                    "slug" => $product->slug,
                    "image" => $product->image,
                    "quantity" => 1,
                    "price" => $priceProduct['price_final_none_format'],
                    "options" => array(
                        'id_version' => $idVersion,
                        'title_version' => $titleVersion,
                    ),
                    "ships" => $ships,
                    "unit" => $product->unit
                ];
            }
        }
        Session::put('cartCopyAdmin' . $request->idCopyCart, $cart);
        Session::save();

        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                $provisional += $item['quantity'] * $item['price'];
                $html .= htmlItemCartCopyAdmin($key, $item);
            }
        }
        $alert['message'] = 'Thêm sản phẩm vào giỏ hàng thành công';
        return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
    }
    public function updateCart(Request $request)
    {
        $alert = array(
            'error' => '',
            'message' => '',
            'html' => '',
            'total' => 0,
            'total_coupon' => 0,
            'total_items' => 0,
            'coupon_price' => 0
        );
        $quantity = $request->quantity;
        $type = $request->type;
        $cart = Session::get('cartCopyAdmin' . $request->idCopyCart);
        if ($type == 'update') {
            if (!empty($request->rowid) && !empty($quantity)) {
                //check tồn kho sản phẩm biến thể
                if (!empty($cart[$request->rowid]["options"])) {
                    $productVersion = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                        ->where('product_id', $cart[$request->rowid]["id"])
                        ->where('id_version',  $cart[$request->rowid]["options"]['id_version'])->first();
                    if (!$productVersion) {
                        $alert['error'] = "Phiên bản sản phẩm không tồn tại";
                        return response()->json(['data' => $alert]);
                    }

                    //check stock
                    $checkCartVariable = checkCart($productVersion, $quantity);
                    if (!empty($checkCartVariable['status'])) {
                        $alert['error'] = $checkCartVariable['message'];
                        return response()->json(['data' => $alert]);
                    }
                    //end

                } else {
                    //check tồn kho sản phẩm đơn giản
                    $product = \App\Models\Product::select('inventory', 'inventoryPolicy', 'inventoryQuantity')->find($cart[$request->rowid]['id']);
                    //check stock
                    $checkCartVariable = checkCart($product, $quantity, 'simple');
                    if (!empty($checkCartVariable['status'])) {
                        $alert['error'] = $checkCartVariable['message'];
                        return response()->json(['data' => $alert]);
                    }
                    //end
                }
                //end
                $cart[$request->rowid]["quantity"] = $request->quantity;
                $alert['message'] = "Cập nhập sản phẩm thành công";
                //return
                Session::put('cartCopyAdmin' . $request->idCopyCart, $cart);
                Session::save();
                $html = '';
                $provisional = 0;
                if (!empty($cart)) {
                    foreach ($cart as $key => $item) {
                        $provisional += $item['quantity'] * $item['price'];
                        $html .= htmlItemCartCopyAdmin($key, $item);
                    }
                }
                return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
            } else {
                $alert['error'] = trans('index.CartUpdateFailed');
                return response()->json(['data' => $alert]);
            }
        } else if ($type == 'delete') {
            if ($request->rowid) {
                if (isset($cart[$request->rowid])) {
                    unset($cart[$request->rowid]);
                    //return
                    $html = '';
                    $provisional = 0;
                    if (!empty($cart)) {
                        foreach ($cart as $key => $item) {
                            $provisional += $item['quantity'] * $item['price'];
                            $html .= htmlItemCartCopyAdmin($key, $item);
                        }
                    }
                    Session::put('cartCopyAdmin' . $request->idCopyCart, $cart);
                    Session::save();
                    $alert['message'] = trans('index.DeleteProductSuccessfully');
                    return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                } else {
                    $alert['error'] = trans('index.CartDeletionFailed');
                    return response()->json(['data' => $alert]);
                }
            } else {
                $alert['error'] = trans('index.CartDeletionFailed');
                return response()->json(['data' => $alert]);
            }
        } else {
            $alert['error'] = trans('index.AnErrorOccurred');
            return response()->json(['data' => $alert]);
        }
        return response()->json(['data' => $alert]);
    }
    public function getLocation(Request $request)
    {
        $param = $request->param;
        $type = $param['type'];
        $table  = '';
        $textWard  = '';
        $temp = '';
        if ($type == 'city') {
            $table = 'vn_district';
            $where = ['ProvinceID' => $param['id']];
            $textWard  =  '<option value="0">' . trans('index.Ward') . '</option>';
        } else if ($type == 'district') {
            $table = 'vn_ward';
            $where = ['DistrictID' => $param['id']];
        }
        $getData = DB::table($table)->select('id', 'name')->where($where)->orderBy('name', 'asc')->get();
        $temp = $temp . '<option value="0">' . $param['text'] . '</option>';
        if (isset($getData)) {
            foreach ($getData as  $val) {
                $temp = $temp . '<option value="' . $val->id . '">' . $val->name . '</option>';
            }
        }
        echo json_encode(array(
            'html' => $temp,
            'textWard' => $textWard,
        ));
        die();
    }
    public function getFeeShip(Request $request)
    {
        $data = getFeeShip($request->cityID, $request->districtID);
        echo json_encode($data);
        die;
        //end
    }
    public function submit(Request $request)
    {
        $id = $request->id; //id đơn hàng
        $customer_id = $request->customer_id;
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email',
            'phone' => ['required', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
            'address' => 'required',
            'city_id' => 'required|gt:0',
            'district_id' => 'required|gt:0',
            'ward_id' => 'required|gt:0',
        ], [
            'fullname.required' => 'Họ và tên là trường bắt buộc.',
            'email.required' => 'Email là trường bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.regex'        => 'Số điện thoại không hợp lệ.',
            'phone.numeric' => 'Số điện thoại không đúng định dạng.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
            'city_id.required' => 'Tỉnh/Thành Phố là trường bắt buộc.',
            'city_id.gt' => 'Tỉnh/Thành Phố là trường bắt buộc.',
            'district_id.required' => 'Quận/Huyện là trường bắt buộc.',
            'district_id.gt' => 'Quận/Huyện là trường bắt buộc.',
            'ward_id.required' => 'Phường/Xã là trường bắt buộc.',
            'ward_id.gt' => 'Phường/Xã là trường bắt buộc.',
        ]);
        if ($validator->passes()) {
            $cart = Session::get('cartCopyAdmin' . $id);
            if (empty($cart)) {
                return response()->json(['error' => 'Giỏ hàng không tồn tại']);
            }
            $detailCustomer = \App\Models\Customer::find($customer_id);
            if (!isset($detailCustomer)) {
                return response()->json(['error' => 'Khách hàng không tồn tại']);
            }
            //START: thuc hien check ton kho
            $total = $total_item = $total_price_coupon = 0;
            if (!empty($cart)) {
                foreach ($cart as $key => $value) {
                    $total += $value['price'] * $value['quantity'];
                    $total_item +=  $value['quantity'];
                    if (!empty($value['options'])) {
                        $getVersionproduct = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                            ->where('product_id', $value["id"])
                            ->where('id_version',  $value["options"]['id_version'])->first();
                        //quản lý kho hàng - không cho đặt hàng khi hết hàng - số lượng tồn kho = 0
                        if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0 && $getVersionproduct['_stock'] == 0) {
                            return response()->json(['error' => 'Sản phẩm ' . $value['title'] . ' - ' . $value["options"]['title_version'] . ' đã hết hàng']);
                        }
                        //check số lượng so với tồn kho
                        if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0) {
                            if ($value['quantity'] > $getVersionproduct['_stock']) {
                                return response()->json(['error' => 'Sản phẩm ' . $value['title'] . '-' . $value['options'] . ' mua tối đa ' . $getVersionproduct['_stock'] . ' sản phẩm']);
                            }
                        }
                    } else {
                        $product = \App\Models\Product::select('id', 'inventory', 'inventoryPolicy', 'inventoryQuantity')->find($value["id"]);
                        //quản lý kho hàng - không cho phép đặt hàng - số lượng tồn kho = 0
                        if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0 && $product['inventoryQuantity'] == 0) {
                            return response()->json(['error' => 'Sản phẩm ' . $value['title'] . ' đã hết hàng']);
                        }
                        //check số lượng so với tồn kho
                        if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0) {
                            if ($value['quantity'] > $product['inventoryQuantity']) {
                                return response()->json(['error' => 'Sản phẩm ' . $value['title'] . ' mua tối đa ' . $product['inventoryQuantity'] . ' sản phẩm']);
                            }
                        }
                    }
                }
            }
            //END
            //START: tính toán ngày sửa đơn Hàng
            $today = \Carbon\Carbon::now()->format('Y-m-d');
            $mo =  \Carbon\Carbon::now()->startOfWeek()->format('Y-m-d');
            $tu =  \Carbon\Carbon::now()->startOfWeek()->addDays(1)->format('Y-m-d'); //thứ 3
            $we =  \Carbon\Carbon::now()->startOfWeek()->addDays(2)->format('Y-m-d'); //thứ 4
            $th =  \Carbon\Carbon::now()->startOfWeek()->addDays(3)->format('Y-m-d'); //thứ 5
            $fr =  \Carbon\Carbon::now()->startOfWeek()->addDays(4)->format('Y-m-d'); //thứ 6
            $sa =  \Carbon\Carbon::now()->startOfWeek()->addDays(5)->format('Y-m-d'); //thứ 7
            $su =  \Carbon\Carbon::now()->startOfWeek()->addDays(6)->format('Y-m-d'); //chủ nhật
            $chunhat = \Carbon\Carbon::now()->startOfWeek()->addDays(6);

            if ($today >= $mo && $today <= $we) {
                $editDate =  $th;
            } else if ($today >= $th && $today <= $sa) {
                $editDate =  $su;
            } else if ($today == $su) {
                $editDate = $chunhat->addDays(4)->format('Y-m-d');
            }
            //END
            $_data = [
                'fullname' => $request->fullname,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
                'note' => $request->note,
                'payment' => "COD",
                'cart' => !empty($cart) ? json_encode($cart) : '',
                'coupon' => !empty($coupon) ? json_encode($coupon) : '',
                'total_price' => $total,
                'total_item' => $total_item,
                'total_price_coupon' => $total_price_coupon,
                'fee_ship' =>  $request->fee_ship,
                'title_ship' => $request->title_ship,
                'status' => 'wait',
                'customerid' => $detailCustomer->id,
                'created_at' => \Carbon\Carbon::now(),
                'edited_at' => !empty($editDate) ? $editDate : '',
                'publish' => 1,
            ];
            $orderID = \App\Models\Order::insertGetId($_data);
            if ($orderID > 0) {
                $code = 'DH' . date('my') . $orderID;
                \App\Models\Order::where('id', $orderID)->update(['code' => $code, 'deleted_at' => '0000-00-00 00:00:00']);
                //lưu order_items
                $tmp_orderItem = [];
                if (!empty($cart)) {
                    foreach ($cart as $v) {
                        $tmp_orderItem[] = array(
                            "order_id" => $orderID,
                            "product_id" => $v['id'],
                            "product_title" => $v['title'],
                            "product_image" => $v['image'],
                            "product_quantity" => $v['quantity'],
                            "product_price" => $v['price'],
                            "product_unit" => !empty($v['unit']) ? $v['unit'] : '',
                            "product_option" => !empty($v['options']) ? json_encode($v['options']) : '',
                            "created_at" => \Carbon\Carbon::now(),
                        );
                    }
                    DB::table('orders_item')->insert($tmp_orderItem);
                }
                //end
                //trừ stock bảng products_version
                if (!empty($tmp_orderItem)) {
                    foreach ($tmp_orderItem as $key => $value) {
                        if (!empty($value['product_option'])) {
                            $product_option = json_decode($value['product_option']);
                            $getVersionproduct = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                                ->where('product_id', $value["product_id"])
                                ->where('id_version', $product_option->id_version)->first();
                            if ($getVersionproduct) {
                                if ($getVersionproduct['_stock_status'] == 1) {
                                    if ($getVersionproduct['_outstock_status']  == 0) {
                                        if ($getVersionproduct['_stock'] > 0) {
                                            \App\Models\ProductVersion::where('id', $getVersionproduct->id)->update(array(
                                                '_stock' => $getVersionproduct['_stock'] - $value['product_quantity']
                                            ));
                                        }
                                    }
                                }
                            }
                        } else {
                            $product = \App\Models\Product::select('id', 'inventory', 'inventoryPolicy', 'inventoryQuantity')->find($value["product_id"]);
                            if ($product) {
                                if ($product['inventory'] == 1) {
                                    if ($product['inventoryPolicy']  == 0) {
                                        if ($product['inventoryQuantity'] > 0) {
                                            DB::table('products')->where('id', $product->id)->update(array(
                                                'inventoryQuantity' => $product['inventoryQuantity'] - $value['product_quantity']
                                            ));
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                //end
                //xóa giỏ hàng
                Session::forget('cartCopyAdmin' . $id);
                Session::save();
                //gui email
                if (!empty($request->emailCheckbox)) {
                    $sendMail = array(
                        'subject' => 'Thông báo! Đặt hàng thành công',
                        'id' => $orderID,
                    );
                    Mail::to($request->email)->cc($detailCustomer->email)->send(new \App\Mail\SendMailCart($sendMail));
                }
                //end
                //ghi log
                \App\Models\OrderLog::insertGetId(array(
                    'note' => 'Mua lại đơn hàng ' . '#' . $code,
                    'user_id' => Auth::user()->id,
                    'created_at' => \Carbon\Carbon::now()
                ));
                //end
            }
            return response()->json(['status' => 200, 'return' => route('customers.orderSuccess', ['id' => $detailCustomer->id, 'orderID' => $orderID])]);
        }
        return response()->json(['error' => collect($validator->errors()->all())->join(' ', ' ')]);
    }
    public function successOrder($id, $orderID)
    {
        $module = $this->table;
        $detailCustomer = \App\Models\Customer::find($id);
        if (!isset($detailCustomer)) {
            return redirect()->route('customers.orders', ['id' => $id])->with('error', "Thành viên không tồn tại");
        }
        $detail = \App\Models\Order::where('customerid', $detailCustomer->id)->with(['city_name', 'district_name', 'ward_name'])->find($orderID);
        if (!isset($detail)) {
            return redirect()->route('customers.orders', ['id' => $detailCustomer->id])->with('error', "Thành viên không tồn tại");
        }
        return view('customer.backend.order.success', compact('module', 'detailCustomer', 'detail'));
    }
}
