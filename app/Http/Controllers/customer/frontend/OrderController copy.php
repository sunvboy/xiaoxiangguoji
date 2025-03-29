<?php

namespace App\Http\Controllers\customer\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Components\System;
use App\Models\Order;
use Auth;
use Session;
use Validator;
use Illuminate\Support\Facades\Redirect;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    /*danh sách đơn hàng theo user*/
    public function index(Request $request)
    {
        $id = Auth::guard('customer')->user()->id;
        $data = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'customerid' => $id])->orderBy('id', 'desc');
        if (is($request->status)) {
            $data =  $data->where('status', $request->status);
        }
        if (is($request->date)) {
            $date =  explode(' to ', $request->date);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('created_at', '>=', $date_start)->where('created_at', '<=', $date_end);
            }
        }
        $data = $data->paginate(10);
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->date)) {
            $data->appends(['date' => $request->date]);
        }
        $fcSystem = $this->system->fcSystem();
        $seo['meta_title'] = trans('index.PurchaseHistory');
        return view('customer/frontend/order/index', compact('fcSystem', 'seo', 'data'));
    }
    /*Chi tiết đơn hàng */
    public function detail($id)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'id' => $id, 'customerid' => $customer_id])->with(['city_name', 'district_name', 'ward_name'])->first();
        if (!isset($detail)) {
            return redirect()->route('customer.orders')->with('error', trans('index.OrderDoesNotExist'));
        }
        $fcSystem = $this->system->fcSystem();
        $seo['meta_title'] = trans('index.OrderDetails') . ' - ' . $detail->code;
        return view('customer/frontend/order/detail', compact('seo', 'detail', 'fcSystem'));
    }
    /*Chỉnh sửa đơn hàng */
    public function edit($id)
    {
        $today = \Carbon\Carbon::now();
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'status' => 'wait', 'id' => $id, 'customerid' => $customer_id])->with(['city_name', 'district_name', 'ward_name'])->first();
        if (!isset($detail)) {
            return redirect()->route('customer.orders')->with('error', trans('index.OrderDoesNotExist'));
        }
        if ($today >= $detail->created_at && $today < \Carbon\Carbon::parse($detail->edited_at)) {
            //Tạo session
            Session::put('cartCopy' . $detail->id, json_decode($detail->cart, TRUE));
            Session::save();
            $cartCopy = Session::get('cartCopy' . $detail->id);
            //end
            $products = \App\Models\Product::where(['alanguage' => config('app.locale'), 'publish' => 0])
                ->orderBy('id', 'desc')
                ->with('product_versions')
                ->paginate(20);

            $getCity = \App\Models\VNCity::orderBy('name', 'asc')->get();
            $getDistrict = \App\Models\VNDistrict::where('ProvinceID', $detail->city_id)->orderBy('name', 'asc')->get();
            $getWard = \App\Models\VNWard::where('DistrictID', $detail->district_id)->orderBy('name', 'asc')->get();
            $listCity['0'] = trans('index.City');
            $listDistrict['0'] = trans('index.District');
            $listWard['0'] = trans('index.Ward');
            if (isset($getCity)) {
                foreach ($getCity as $key => $val) {
                    $listCity[$val->id] = $val->name;
                }
            }
            if (isset($getDistrict)) {
                foreach ($getDistrict as $key => $val) {
                    $listDistrict[$val->id] = $val->name;
                }
            }
            if (isset($getWard)) {
                foreach ($getWard as $key => $val) {
                    $listWard[$val->id] = $val->name;
                }
            }
            //lấy phí vận chuyển
            $getFeeShip = getFeeShip($detail->city_id, $detail->district_id);
            $fcSystem = $this->system->fcSystem();
            $seo['meta_title'] = trans('index.UpdateOrder') . ' - ' . $detail->code;
            return view('customer/frontend/order/edit', compact('seo', 'detail', 'fcSystem', 'products', 'listCity', 'listDistrict', 'listWard', 'cartCopy', 'getFeeShip'));
        } else {
            return redirect()->route('customer.orders')->with('error', trans('index.OrderDoesNotExist'));
        }
    }
    /*Submit: Cập nhập đơn hàng */
    public function update(Request $request, $id)
    {
        $today = \Carbon\Carbon::now();
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'status' => 'wait', 'id' => $id, 'customerid' => $customer_id])->with(['city_name', 'district_name', 'ward_name'])->first();
        if (!isset($detail)) {
            return response()->json(['data' => trans('index.OrderDoesNotExist')]);
        }
        if ($today >= $detail->created_at && $today < \Carbon\Carbon::parse($detail->edited_at)) {
            if (config('app.locale') == 'vi') {
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
                    'email.email' => 'Email không đúng định dạng',
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
            } else if (config('app.locale') == 'gm') {
                $validator = Validator::make($request->all(), [
                    'fullname' => 'required',
                    'email' => 'required|email',
                    'phone' => ['required', 'numeric'],
                    'address' => 'required',
                    'city_id' => 'required|gt:0',
                    'district_id' => 'required|gt:0',
                    'ward_id' => 'required|gt:0',
                ], [
                    'fullname.required' => 'Vor- und Nachname sind Pflichtfelder.',
                    'email.required' => 'E-Mail ist ein Pflichtfeld.',
                    'email.email' => 'Ungültiges E-Mail-Format',
                    'phone.required' => 'Telefonnummer darf nicht leer sein.',
                    'phone.numeric' => 'Telefonnummer hat nicht das richtige Format.',
                    'address.required' => 'Adresse ist ein Pflichtfeld.',
                    'city_id.required' => 'Provinz/Stadt ist Pflichtfeld.',
                    'city_id.gt' => 'Provinz/Stadt ist Pflichtfeld.',
                    'district_id.required' => 'Distrikt/Distrikt ist ein Pflichtfeld.',
                    'district_id.gt' => 'Bezirk/Bezirk ist ein Pflichtfeld.',
                    'ward_id.required' => 'Gemeinde/Gemeinde ist ein Pflichtfeld.',
                    'ward_id.gt' => 'Gemeinde/Gemeinde ist ein Pflichtfeld.',
                ]);
            } else if (config('app.locale') == 'tl') {
                $validator = Validator::make($request->all(), [
                    'fullname' => 'required',
                    'email' => 'required|email',
                    'phone' => ['required', 'numeric'],
                    'address' => 'required',
                    'city_id' => 'required|gt:0',
                    'district_id' => 'required|gt:0',
                    'ward_id' => 'required|gt:0',
                ], [
                    'fullname.required' => 'ชื่อและนามสกุลเป็นฟิลด์บังคับ',
                    'email.required' => 'อีเมลเป็นฟิลด์บังคับ',
                    'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                    'phone.required' => 'หมายเลขโทรศัพท์ต้องไม่เว้นว่าง',
                    'phone.numeric' => 'หมายเลขโทรศัพท์ไม่อยู่ในรูปแบบที่ถูกต้อง',
                    'address.required' => 'ที่อยู่เป็นฟิลด์บังคับ',
                    'city_id.required' => 'จังหวัด/เมือง เป็นฟิลด์บังคับ',
                    'city_id.gt' => 'จังหวัด/เมือง จำเป็นต้องกรอก',
                    'district_id.required' => 'เขต/เขตเป็นฟิลด์บังคับ',
                    'district_id.gt' => 'เขต/เขตเป็นฟิลด์บังคับ',
                    'ward_id.required' => 'วอร์ด/ชุมชนเป็นฟิลด์บังคับ',
                    'ward_id.gt' => 'วอร์ด/ชุมชนเป็นฟิลด์บังคับ',
                ]);
            } else {
                $validator = Validator::make($request->all(), [
                    'fullname' => 'required',
                    'email' => 'required|email',
                    'phone' => ['required', 'numeric'],
                    'address' => 'required',
                    'city_id' => 'required|gt:0',
                    'district_id' => 'required|gt:0',
                    'ward_id' => 'required|gt:0',
                ]);
            }
            if ($validator->passes()) {
                $cart = Session::get('cartCopy' . $id);
                //thuc hien check ton kho
                $arrStock = [];
                if (isset($cart)) {
                    foreach ($cart as $key => $value) {
                        if (!empty($value['options'])) {
                            $getVersionproduct = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                                ->with('product_stocks')
                                ->where('product_id', $value["id"])
                                ->where('id_version',  $value["options"]['id_version'])->first();
                            //quản lý kho hàng - không cho đặt hàng khi hết hàng - số lượng bằng 0
                            if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0 && $getVersionproduct['_stock'] == 0) {
                                array_push($arrStock, 'Sản phẩm ' . $value['title'] . '-' . $value['options'] . ' đã hết hàng');
                            }
                        } else {
                            $product = \App\Models\Product::select('id', 'inventory', 'inventoryPolicy', 'inventoryQuantity')->with('product_stocks')->find($value["id"]);
                            if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0 && $product['inventoryQuantity'] == 0) {
                                array_push($arrStock, 'Sản phẩm ' . $value['title'] . ' đã hết hàng');
                            }
                        }
                    }
                }

                if (!empty($arrStock)) {
                    return response()->json(['error' => $arrStock]);
                }
                //endif
                $total = $total_item = 0;
                if (!empty($cart)) {
                    foreach ($cart as $v) {
                        $total += $v['price'] * $v['quantity'];
                        $total_item +=  $v['quantity'];
                    }
                    $_data = [
                        'fullname' => $request->fullname,
                        'email' => $request->email,
                        'phone' => $request->phone,
                        'address' => $request->address,
                        'city_id' => $request->city_id,
                        'district_id' => $request->district_id,
                        'ward_id' => $request->ward_id,
                        'note' => $request->note,
                        'cart' => !empty($cart) ? json_encode($cart) : '',
                        'total_price' => $total,
                        'total_item' => $total_item,
                        'fee_ship' => $request->fee_ship,
                        'title_ship' => $request->title_ship,
                        'status' => 'wait',
                        'created_at' => \Carbon\Carbon::now(),
                    ];
                    \App\Models\Order::where('id', $id)->update($_data);
                    Session::forget('cartCopy' . $id);
                    return response()->json(['status' => '200']);
                } else {
                    return response()->json(['error' => 'ERROR']);
                }
            }
            return response()->json(['error' => $validator->errors()->all()]);
        } else {
            return response()->json(['data' => trans('index.OrderDoesNotExist')]);
        }
    }
    /*Xóa đơn hàng */
    public function delete(Request $request)
    {
        $id = $request->id;
        $today = \Carbon\Carbon::now();
        $customer_id = Auth::guard('customer')->user()->id;
        $oldPrice = Auth::guard('customer')->user()->price;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'status' => 'wait', 'id' => $id, 'customerid' => $customer_id])->first();

        if (!isset($detail)) {
            return response()->json(['data' => trans('index.OrderDoesNotExist')]);
        }
        if ($today >= $detail->created_at && $today < \Carbon\Carbon::parse($detail->edited_at)) {
            Order::where('id', $id)->update(['edited_at' => '0000-00-00 00:00:00', 'status' => 'canceled']);
            if ($detail->payment == 'wallet') {
                $price = $detail->wallet;
                \App\Models\Customer::where('id', $customer_id)->update(['price' => $price + Auth::guard('customer')->user()->price]);
                //ghi log
                \App\Models\CustomerLog::insertGetId(array(
                    'note' => Auth::guard('customer')->user()->name . ' <span style="color:green;font-weight:bold">+ ' . number_format($price, '0', ',', '.') . 'đ</span> ' . 'hủy đơn hàng có ID =' . $detail->id,
                    'customer_id' => $customer_id,
                    'oldPrice' => $oldPrice,
                    'finalPrice' => $price + Auth::guard('customer')->user()->price,
                    'created_at' => \Carbon\Carbon::now()
                ));
                //end
            }
            return response()->json(['status' => 200]);
        } else {
            return response()->json(['error' => 'ERROR']);
        }
    }
    /*Mua lại đơn hàng */
    public function copy($id)
    {
        Session::forget('copyCartID');
        $fcSystem = $this->system->fcSystem();
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'id' => $id, 'customerid' => $customer_id])->with(['city_name', 'district_name', 'ward_name'])->first();
        if (!isset($detail)) {
            return redirect()->route('customer.orders')->with('error', trans('index.OrderDoesNotExist'));
        }
        //Tạo session
        $cart = Session::get('cartCopy' . $detail->id);
        if (empty($cart)) {
            Session::put('cartCopy' . $detail->id, json_decode($detail->cart, TRUE));
            Session::save();
        }
        $cartCopy = !empty($cart) ? $cart : json_decode($detail->cart, TRUE);
        //end
        $products = \App\Models\Product::where(['alanguage' => config('app.locale'), 'publish' => 0])
            ->orderBy('id', 'desc')
            ->with('product_versions')
            ->paginate(20);
        $getCity = \App\Models\VNCity::orderBy('name', 'asc')->get();
        $getDistrict = \App\Models\VNDistrict::where('ProvinceID', $detail->city_id)->orderBy('name', 'asc')->get();
        $getWard = \App\Models\VNWard::where('DistrictID', $detail->district_id)->orderBy('name', 'asc')->get();
        $listCity['0'] = trans('index.City');
        $listDistrict['0'] = trans('index.District');
        $listWard['0'] = trans('index.Ward');
        if (isset($getCity)) {
            foreach ($getCity as $key => $val) {
                $listCity[$val->id] = $val->name;
            }
        }
        if (isset($getDistrict)) {
            foreach ($getDistrict as $key => $val) {
                $listDistrict[$val->id] = $val->name;
            }
        }
        if (isset($getWard)) {
            foreach ($getWard as $key => $val) {
                $listWard[$val->id] = $val->name;
            }
        }
        //lấy phí vận chuyển
        $getFeeShip = getFeeShip($detail->city_id, $detail->district_id);
        $payments = \App\Models\orderConfig::select('id', 'title', 'description', 'image', 'keyword')->where('publish', 0)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $seo['meta_title'] = trans('index.ReOrder') . ' - ' . $detail->code;
        return view('customer/frontend/order/copy', compact('seo', 'detail', 'fcSystem', 'products', 'listCity', 'listDistrict', 'listWard', 'payments', 'cartCopy', 'getFeeShip'));
    }
    /*Danh sách sản phẩm search Ajax */
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
        return view('customer.frontend.order.dataProduct', compact('products'))->render();
    }
    /*Thêm sản phẩm vào trong giỏ hàng */
    public function addToCartCopyOrder(Request $request)
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
        $quantity = 1;
        $cart = Session::get('cartCopy' . $request->idCopyCart);
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'id' => $request->idCopyCart, 'customerid' => $customer_id])->first();
        if (!isset($detail) || !$cart) {
            $alert['error'] = 'Đơn hàng không tồn tại';
            return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
        }
        $id = $request->id;
        $idVersion = $request->idVersion;
        $titleVersion = $request->titleVersion;
        $titleVersion = collect(json_decode($request->titleVersion, TRUE))->join(',', '');
        $product = \App\Models\Product::select('id', 'title', 'slug', 'price', 'price_sale', 'price_contact', 'unit', 'inventory', 'inventoryPolicy', 'inventoryQuantity', 'catalogue_id', 'image', 'ships')
            ->with('product_versions')->find($id);
        if (!$product) {
            $alert['error'] = trans('index.ProductDoesNotExist');
            return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
        }
        if (count($product->product_versions) > 0) {
            if (!empty($idVersion)) {
                $productVersion = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                    ->with('product_stocks')
                    ->where('product_id', $id)
                    ->where('id_version', $idVersion)
                    ->first();
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
                    "unit" => $product->unit,
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
                    "unit" => $product->unit,
                ];
            }
        }
        Session::put('cartCopy' . $request->idCopyCart, $cart);
        Session::save();
        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                $provisional += $item['quantity'] * $item['price'];
                $html .= htmlItemCartCopyCustomer($key, $item);
            }
        }
        return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
    }
    /*Cập nhập và xóa giỏ hàng */
    public function updateCartCopyOrder(Request $request)
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
        $rowid = $request->rowid;
        $cart = Session::get('cartCopy' . $request->idCopyCart);
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'id' => $request->idCopyCart, 'customerid' => $customer_id])->first();
        if (!isset($detail) || !$cart) {
            $alert['error'] = 'Đơn hàng không tồn tại';
            return response()->json(['data' => $alert]);
        }
        if ($type == 'update') {
            if ($rowid and $quantity) {
                //check tồn kho sản phẩm biến thể
                if (!empty($cart[$rowid]["options"])) {
                    $productVersion = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                        ->with('product_stocks')
                        ->where('product_id', $cart[$rowid]["id"])
                        ->where('id_version',  $cart[$rowid]["options"]['id_version'])->first();
                    if (!$productVersion) {
                        $alert['error'] = trans('index.ProductVersionDoesNotExist');
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
                    $product = \App\Models\Product::select('inventory', 'inventoryPolicy', 'inventoryQuantity')->with('product_stocks')->find($cart[$request->rowid]['id']);
                    //check stock
                    $checkCartVariable = checkCart($product, $quantity, 'simple');
                    if (!empty($checkCartVariable['status'])) {
                        $alert['error'] = $checkCartVariable['message'];
                        return response()->json(['data' => $alert]);
                    }
                    //end
                }
                //end
                $cart[$rowid]["quantity"] = $quantity;
                $alert['message'] = trans('index.ProductUpdate');
                //return
                Session::put('cartCopy' . $request->idCopyCart, $cart);
                Session::save();
                $html = '';
                $provisional = 0;
                if (!empty($cart)) {
                    foreach ($cart as $key => $item) {
                        $provisional += $item['quantity'] * $item['price'];
                        $html .= htmlItemCartCopyCustomer($key, $item);
                    }
                }
                return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
            } else {
                $alert['error'] = trans('index.CartUpdateFailed');
                return response()->json(['data' => $alert]);
            }
        } else if ($type == 'delete') {
            if ($rowid) {
                if (isset($cart[$rowid])) {
                    unset($cart[$rowid]);
                    //return
                    $html = '';
                    $provisional = 0;
                    if (!empty($cart)) {
                        foreach ($cart as $key => $item) {
                            $provisional += $item['quantity'] * $item['price'];
                            $html .= htmlItemCartCopyCustomer($key, $item);
                        }
                    }
                    Session::put('cartCopy' . $request->idCopyCart, $cart);
                    Session::save();
                    $alert['message'] = trans('index.DeleteProductSuccessfully');
                    return response()->json(['data' => $alert, 'html' => $html, 'provisional' => $provisional]);
                } else {
                    $alert['error'] = trans('index.CartDeletionFailed');
                }
            } else {
                $alert['error'] = trans('index.CartDeletionFailed');
            }
        } else {
            $alert['error'] = trans('index.AnErrorOccurred');
        }
        return response()->json(['data' => $alert]);
    }
    /*validate checkout */
    public function validateFormCopyCart(Request $request)
    {
        $cart = Session::get('cartCopy' . $request->copyCartID);
        if (empty($cart)) {
            return response()->json(['error' => trans('index.YouHaveNotSelectedProduct')]);
        }
        if (config('app.locale') == 'vi') {
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
                'email.email' => 'Email không đúng định dạng',
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
        } else if (config('app.locale') == 'gm') {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'numeric'],
                'address' => 'required',
                'city_id' => 'required|gt:0',
                'district_id' => 'required|gt:0',
                'ward_id' => 'required|gt:0',
            ], [
                'fullname.required' => 'Vor- und Nachname sind Pflichtfelder.',
                'email.required' => 'E-Mail ist ein Pflichtfeld.',
                'email.email' => 'Ungültiges E-Mail-Format',
                'phone.required' => 'Telefonnummer darf nicht leer sein.',
                'phone.numeric' => 'Telefonnummer hat nicht das richtige Format.',
                'address.required' => 'Adresse ist ein Pflichtfeld.',
                'city_id.required' => 'Provinz/Stadt ist Pflichtfeld.',
                'city_id.gt' => 'Provinz/Stadt ist Pflichtfeld.',
                'district_id.required' => 'Distrikt/Distrikt ist ein Pflichtfeld.',
                'district_id.gt' => 'Bezirk/Bezirk ist ein Pflichtfeld.',
                'ward_id.required' => 'Gemeinde/Gemeinde ist ein Pflichtfeld.',
                'ward_id.gt' => 'Gemeinde/Gemeinde ist ein Pflichtfeld.',
            ]);
        } else if (config('app.locale') == 'tl') {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'numeric'],
                'address' => 'required',
                'city_id' => 'required|gt:0',
                'district_id' => 'required|gt:0',
                'ward_id' => 'required|gt:0',
            ], [
                'fullname.required' => 'ชื่อและนามสกุลเป็นฟิลด์บังคับ',
                'email.required' => 'อีเมลเป็นฟิลด์บังคับ',
                'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
                'phone.required' => 'หมายเลขโทรศัพท์ต้องไม่เว้นว่าง',
                'phone.numeric' => 'หมายเลขโทรศัพท์ไม่อยู่ในรูปแบบที่ถูกต้อง',
                'address.required' => 'ที่อยู่เป็นฟิลด์บังคับ',
                'city_id.required' => 'จังหวัด/เมือง เป็นฟิลด์บังคับ',
                'city_id.gt' => 'จังหวัด/เมือง จำเป็นต้องกรอก',
                'district_id.required' => 'เขต/เขตเป็นฟิลด์บังคับ',
                'district_id.gt' => 'เขต/เขตเป็นฟิลด์บังคับ',
                'ward_id.required' => 'วอร์ด/ชุมชนเป็นฟิลด์บังคับ',
                'ward_id.gt' => 'วอร์ด/ชุมชนเป็นฟิลด์บังคับ',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'numeric'],
                'address' => 'required',
                'city_id' => 'required|gt:0',
                'district_id' => 'required|gt:0',
                'ward_id' => 'required|gt:0',
            ]);
        }
        if ($validator->passes()) {
            //thuc hien check ton kho
            $arrStock = [];
            if (isset($cart)) {
                foreach ($cart as $key => $value) {
                    if (!empty($value['options'])) {
                        $getVersionproduct = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                            ->with('product_stocks')
                            ->where('product_id', $value["id"])
                            ->where('id_version',  $value["options"]['id_version'])->first();
                        //quản lý kho hàng - không cho đặt hàng khi hết hàng - số lượng bằng 0
                        if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0 && $getVersionproduct['_stock'] == 0) {
                            array_push($arrStock, 'Sản phẩm ' . $value['title'] . '-' . $value['options'] . ' đã hết hàng');
                        }
                        //check số lượng so với tồn kho
                        if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0) {
                            if ($value['quantity'] > $getVersionproduct['_stock']) {
                                array_push($arrStock, 'Sản phẩm ' . $value['title'] . '-' . $value['options'] . ' mua tối đa ' . $getVersionproduct['_stock'] . ' sản phẩm');
                            }
                        }
                    } else {
                        $product = \App\Models\Product::select('id', 'inventory', 'inventoryPolicy', 'inventoryQuantity')->find($value["id"]);
                        if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0 && $product['inventoryQuantity'] == 0) {
                            array_push($arrStock, 'Sản phẩm ' . $value['title'] . ' đã hết hàng');
                        }
                        //check số lượng so với tồn kho
                        if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0) {
                            if ($value['quantity'] > $product['inventoryQuantity']) {
                                array_push($arrStock, 'Sản phẩm ' . $value['title'] . ' mua tối đa ' . $product['inventoryQuantity'] . ' sản phẩm');
                            }
                        }
                    }
                }
            }
            if (!empty($arrStock)) {
                $html = '';
                foreach ($arrStock as $item) {
                    $html .= $item . '/';
                }
                return response()->json(['error' => $html]);
            } else {
                return response()->json(['status' => '200']);
            }
            //endif
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    /*Ajax: hoàn hàng */
    public function returnOrder(Request $request)
    {
        $alert = array(
            'error' => '',
            'message' => '',
        );
        $id = $request->id;
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'id' => $id, 'status' => 'completed', 'customerid' => $customer_id])->first();
        if (!isset($detail)) {
            $alert['error'] = trans('site.OrderDoesNotExist');
        }
        $cart = json_decode($detail->cart, TRUE);
        $html = '<div class="listCart space-y-3 scrollbar max-h-[400px]">';
        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                $unit = !empty($item['unit']) ? $item['unit'] : '';
                $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
                $html .= '<input class="" type="hidden" name="orderID" value="' . $detail->id . '">
                
                <div class="flex flex-col md:flex-row space-y-2 md:space-y-0 space-x-0 md:space-x-2">
                        <div class="w-full md:w-1/2 flex space-x-3">
                            <div class="w-[50px]">
                                <img alt="' . $item['title'] . '" class="border w-full object-cover" src="' . asset($item['image']) . '">
                            </div>
                            <div class="flex-1">
                                <a href="javascript:void(0)" class="text-blue-500">' . $item['title'] . '</a>';
                if (!empty($title_version)) {
                    $html .= '<p class="subdued text-xs">' . trans('index.Classify') . ': ' . $title_version . '</p>';
                }
                $html .= '<p class="subdued text-xs">' . trans('index.Amount') . ': ' . $item['quantity'] . ' ' . $unit . '</p>';

                $html .= '</div>
                        </div>
                        <div class="w-full md:w-1/2 flex space-x-2 items-center justify-between">
                            <div w-1/3>' . number_format($item['price'], '0', '.', ',') . '₫ x </div>
                            <div w-1/3>
                                <input type="hidden" name="rowid[]" value="' . $key . '">
                                <input name="quantity[]" data-price="' . $item['price'] . '" max="' . $item['quantity'] . '" min="0" size="30" type="number" class="text-center border h-9 leading-9 text-black pl-2 focus:outline-none rounded js_change_return_cart w-16" value="0">
                            </div>
                            <div class="js_priceOfItem w-1/3 text-right">0₫
                            </div>
                        </div>
                    </div>';
            }
        }
        $html .= '</div>';
        $html .= '<div class="space-y-2">
                    <div class="flex justify-between">
                        <div class="w-1/2 md:w-2/3 text-right space-x-2">
                            ' . trans('index.TotalAmount') . '
                        </div>
                        <div class="w-1/2 md:w-1/3 text-right">
                            <b class="js_total_price_return">
                                0₫
                            </b>
                        </div>
                    </div>';
        if (!empty($detail->total_price_coupon)) {
            $html .= '<div class="flex justify-between">
                        <div class="w-1/2 md:w-2/3 text-right space-x-2">
                           ' . trans('index.Discount') . '
                        </div>
                        <div class="w-1/2 md:w-1/3 text-right">
                            <b class="">
                               -' . number_format($detail->total_price_coupon, '0', ',', '.') . '₫
                            </b>
                        </div>
                    </div>';
        }


        $html .= '<div class="flex justify-between items-center space-x-2 hidden">
                        <div class="w-1/2 md:w-2/3 text-right">
                            ' . trans('index.TransportFee') . ' (Còn  ' . number_format($detail->fee_ship, '0', '.', ',') . '₫)
                        </div>
                        <div class="w-1/2 md:w-1/3 text-right ">
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="">
                        </div>
                    </div>
                    <div class="flex justify-between items-center space-x-2">
                        <div class="w-1/2 md:w-2/3 text-right">
                            ' . trans('index.TotalAmountThatCanBeRefunded') . '
                        </div>
                        <div class="w-1/2 md:w-1/3 text-right">
                            <b class="total_price_return_order">
                            ' . number_format($detail->total_price - $detail->total_price_coupon, '0', ',', '.') . '₫
                            </b>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-100 border-t border-gray-400 p-3 space-y-2 hidden">
                    <div class="flex justify-between items-center space-x-2">
                        <div class="w-1/2 md:w-2/3 text-right">
                            ' . trans('index.RefundToMethod') . ' ' . $detail->title_ship . '
                        </div>
                        <div class="w-1/2 md:w-1/3 text-right ">
                            <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="">
                        </div>
                    </div>
                    <div class="flex justify-end items-center">
                        <label class="">
                            <input type="checkbox" name="">
                            Hoàn kho <span class="js_quantity_return_order">0</span> sản phẩm
                        </label>
                    </div>
                </div>';

        return response()->json(['data' => $alert, 'html' => $html]);
    }
    /*Ajax: submit hoàn hàng */
    public function returnOrderSubmit(Request $request)
    {
        $alert = array(
            'error' => '',
            'status' => '200',
        );
        $rowid = $request->rowid;
        $quantity = $request->quantity;
        $orderID = $request->orderID;
        $total = 0;
        $data = [];
        if (!empty($quantity)) {
            foreach ($quantity as $key => $item) {
                if (is_numeric($item)) {
                    $total = $total + $item;
                    $data[$rowid[$key]] = $item;
                } else {
                    $alert['error'] = 'Số lượng sản phẩm phải là số';
                    $alert['status'] = '500';
                    return response()->json(['data' => $alert]);
                }
            }
        }
        if ($total == 0) {
            $alert['error'] = trans('index.NoProductQuantityExists');
            $alert['status'] = '500';
            return response()->json(['data' => $alert]);
        }
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1, 'id' => $orderID, 'status' => 'completed', 'customerid' => $customer_id])->first();
        if (!isset($detail)) {
            $alert['error'] = trans('index.OrderDoesNotExist');
            $alert['status'] = '500';
            return response()->json(['data' => $alert]);
        }
        $cart = json_decode($detail->cart, TRUE);
        $cartNew = [];
        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                if ($data[$key] > $item['quantity']) {
                    $alert['error'] = trans('index.TheNumberOfProducts', ['title' => $item['title'], 'quantity' => $item['quantity']]);
                    $alert['status'] = '500';
                    return response()->json(['data' => $alert]);
                }
                $cartNew[$key] = collect($item)->put('quantity_return', (int)$data[$key]);
            }
        }
        $_data = [
            'cart' => !empty($cartNew) ? json_encode($cartNew) : '',
            'order_id' => $detail->id,
            'status' => 0,
            'created_at' => \Carbon\Carbon::now(),
        ];
        $id =  \App\Models\OrderReturn::insertGetId($_data);
        if ($id > 0) {
            //update trạng thái đơn hàng
            \App\Models\Order::where(['id' => $detail->id, 'customerid' => $customer_id])->update(array('status' => 'returns'));
            $alert['status'] = '200';
            return response()->json(['data' => $alert]);
        }
    }
}
