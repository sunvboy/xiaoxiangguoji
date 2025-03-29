<?php

namespace App\Http\Controllers\order\frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;
use Auth;
use Illuminate\Support\Facades\Redirect;
use App\Components\Coupon as CouponHelper;
use App\Components\System;
use App\Models\Coupon;
use App\Models\Coupon_relationship;
use Illuminate\Support\Facades\Mail;
use Validator;


class OrderController extends Controller
{
    protected $coupon;

    public function __construct()
    {
        $this->coupon = new CouponHelper();
        $this->system = new System();
    }
    public function configVNPAY()
    {
        $configVNPAY = [];
        $detail = \App\Models\orderConfig::select('config')->where('id', 3)->where('publish', 0)->first();
        if ($detail) {
            $jsonConfig = json_decode($detail->config, TRUE);
            if (!empty($jsonConfig)) {
                $configVNPAY = array(
                    'TmnCode'  => $jsonConfig['TmnCode'],
                    'HashSecret'  => $jsonConfig['HashSecret'],
                    'Url'  => $jsonConfig['Url'],
                );
            }
        }
        return $configVNPAY;
    }
    public function configMOMO()
    {
        $configMOMO = [];
        $detail = \App\Models\orderConfig::select('config')->where('publish', 0)->where('id', 4)->first();
        if ($detail) {
            $jsonConfig = json_decode($detail->config, TRUE);
            if (!empty($jsonConfig)) {
                $configMOMO = array(
                    'endpoint'  => $jsonConfig['endpoint'],
                    'partnerCode'  => $jsonConfig['partnerCode'],
                    'accessKey'  => $jsonConfig['accessKey'],
                    'secretKey'  => $jsonConfig['secretKey'],
                );
            }
        }
        return $configMOMO;
    }

    public function order(Request $request)
    {
        //START: tính toán ngày sửa đơn Hàng
        /* $today = \Carbon\Carbon::now()->format('Y-m-d');
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
        } */
        //END
        //START: copy đơn hàng
        $copyCartID = $request->copyCartID;
        if (!empty($copyCartID)) {
            $cart = Session::get('cartCopy' . $copyCartID);
            Session::put('copyCartID', $copyCartID);
        } else {
            $cart = Session::get('cart');
        }
        //END
        //START: thuc hien check ton kho
        $arrStock = [];
        if (isset($cart)) {
            foreach ($cart as $key => $value) {
                if (!empty($value['options'])) {
                    $getVersionproduct = \App\Models\ProductVersion::select('id', '_stock_status', '_stock', '_outstock_status')
                        ->where('product_id', $value["id"])
                        ->where('id_version',  $value["options"]['id_version'])->first();
                    //quản lý kho hàng - không cho đặt hàng khi hết hàng - số lượng tồn kho = 0
                    if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0 && $getVersionproduct['_stock'] == 0) {
                        array_push($arrStock, trans('index.productMaxOutStockVersion', ['title' => $value['title'], 'options' => $value['options']]));
                    }
                    //check số lượng so với tồn kho
                    if ($getVersionproduct['_stock_status'] == 1 && $getVersionproduct['_outstock_status']  == 0) {
                        if ($value['quantity'] > $getVersionproduct['_stock']) {
                            array_push($arrStock, trans('index.productMaxVersion', ['title' => $value['title'], 'options' => $value['options'], 'stock' => $getVersionproduct['_stock']]));
                        }
                    }
                } else {
                    $product = \App\Models\Product::select('id', 'inventory', 'inventoryPolicy', 'inventoryQuantity')->find($value["id"]);
                    //quản lý kho hàng - không cho phép đặt hàng - số lượng tồn kho = 0
                    if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0 && $product['inventoryQuantity'] == 0) {
                        array_push($arrStock, trans('index.productMaxOutStock', ['title' => $value['title']]));
                    }
                    //check số lượng so với tồn kho
                    if ($product['inventory'] == 1 && $product['inventoryPolicy']  == 0) {
                        if ($value['quantity'] > $product['inventoryQuantity']) {
                            array_push($arrStock, trans('index.productMax', ['title' => $value['title'], 'stock' => $product['inventoryQuantity']]));
                        }
                    }
                }
            }
        }
        if (!empty($arrStock)) {
            return redirect()->back()->withErrors(['errors' => $arrStock]);
        }
        //END
        if (config('app.locale') == 'vi') {
            $request->validate([
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
        } else {
            $request->validate([
                'fullname' => 'required',
                'email' => 'required|email',
                'phone' => ['required', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
                'address' => 'required',
                'city_id' => 'required|gt:0',
                'district_id' => 'required|gt:0',
                'ward_id' => 'required|gt:0',
            ]);
        }
        $payment = $request->payment;
        $fee_ship = !empty($request->fee_ship) ? $request->fee_ship : 0;
        $total = $total_item = $total_price_coupon = 0;
        $coupon = Session::get('coupon');
        //START: check giảm giá theo user
        if (!empty($coupon)) {
            //lấy những mã giảm giá giới hạn số lượng
            $checkuser = Coupon::whereIn('id', array_keys($coupon))->where('limit_user', '!=', NULL)->select('id', 'name', 'limit_user')->get();
            if ($checkuser->count() > 0) {
                foreach ($checkuser as $v) {
                    // $tmp_checkuser[] = $v->coupon_relationship_one->orderid;
                    $getEmail = DB::table('coupons_relationships')->where('coupon_id', $v->id)->where('email', $request->email)->count();
                    if ($getEmail >= $v['limit_user']) {
                        return Redirect::route('cart.checkout')->with('error', trans('index.', ['name.notCoupon' => $v->name]));
                    }
                }
            }
        }
        //END
        if ($cart) {
            foreach ($cart as $v) {
                $total += $v['price'] * $v['quantity'];
                $total_item +=  $v['quantity'];
            }
            //nếu tồn tại mã giảm giá thì tính toán lại
            if (!empty($coupon)) {
                foreach ($coupon as $v) {
                    $this->coupon->getCoupon($v['name'], FALSE);
                }
            }
            $coupon = Session::get('coupon');
            if (!empty($coupon)) {
                foreach ($coupon as $v) {
                    $total_price_coupon += $v['price'];
                }
            }
            //end
        }
        //START: lưu thông tin khách hàng vào session
        $_data = [
            'fullname' => $request->fullname,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'note' => $request->note,
            'payment' => $payment,
            'cart' => !empty($cart) ? json_encode($cart) : '',
            'coupon' => !empty($coupon) ? json_encode($coupon) : '',
            'total_price' => $total,
            'total_item' => $total_item,
            'total_price_coupon' => $total_price_coupon,
            'fee_ship' => $fee_ship,
            'title_ship' => $request->title_ship,
            'status' => 'wait',
            'customerid' => !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : 0,
            'created_at' => Carbon::now(),
            'edited_at' => !empty($editDate) ? $editDate : '',
            'publish' => 0,
        ];
        Session::put('orderinfo', $_data);
        Session::save();
        //END
        $totalPrice = (int)$total + (float)$fee_ship - $total_price_coupon; //Tổng tiền
        $orderID = $this->saveOrder(); //thực hiện lưu vào bảng order
        if ($payment == 'COD' || $payment == 'BANKING') { //thanh toán COD và Banking
            Order::where('id', $orderID)->update(['publish' => 1]);
            $this->saveOrderItems($orderID);
            $this->saveCouponsRelationships($orderID);
            $this->sendMailOrder($orderID);
            //xóa session copy cart
            if (!empty($copyCartID)) {
                Session::forget('cartCopy' . $copyCartID);
                Session::forget('copyCartID');
            }
            //end
            return redirect()->route('cart.success', $orderID)->with('success', trans('index.OrderSuccess'));
        } else if ($payment == 'wallet') { //thanh toán qua số dư ví
            $customerID = Auth::guard('customer')->user()->id;
            $walletPrice = Auth::guard('customer')->user()->price;

            if (!empty($walletPrice)) {
                if ($walletPrice > $totalPrice) {
                    $returnPrice = $walletPrice - $totalPrice; //số tiền đã thanh toán
                    \App\Models\Customer::where('id', $customerID)->update(['price' => $returnPrice]); // cập nhập số dư của khách hàng
                    Order::where('id', $orderID)->update(['publish' => 1, 'wallet' => $totalPrice]); //cập lại trạng thái và số tiền đã thanh toán
                    //ghi log thanh toán
                    \App\Models\CustomerLog::insertGetId(array(
                        'note' => Auth::guard('customer')->user()->name . ' <span style="color:red;font-weight:bold">- ' . number_format($totalPrice, '0', ',', '.') . 'đ</span> ' . 'hoàn/trả đơn hàng có ID =' . $orderID,
                        'customer_id' => $customerID,
                        'oldPrice' => $walletPrice,
                        'finalPrice' => $returnPrice,
                        'created_at' => \Carbon\Carbon::now()
                    ));
                    //end
                } else if ($walletPrice <= $totalPrice) {
                    $returnPrice = $totalPrice - $walletPrice; // số tiền đã thanh toán
                    \App\Models\Customer::where('id', $customerID)->update(['price' => 0]); // cập nhập số dư của khách hàng
                    Order::where('id', $orderID)->update(['publish' => 1, 'wallet' => $walletPrice]); //cập lại trạng thái và số tiền đã thanh toán
                    //ghi log thanh toán
                    \App\Models\CustomerLog::insertGetId(array(
                        'note' => Auth::guard('customer')->user()->name . ' <span style="color:red;font-weight:bold">- ' . number_format($walletPrice, '0', ',', '.') . 'đ</span> ' . 'hoàn/trả đơn hàng có ID =' . $orderID,
                        'customer_id' => $customerID,
                        'oldPrice' => $walletPrice,
                        'finalPrice' => 0,
                        'created_at' => \Carbon\Carbon::now()
                    ));
                    //end
                }
                $this->saveOrderItems($orderID);
                $this->saveCouponsRelationships($orderID);
                $this->sendMailOrder($orderID);
                //xóa session copy cart
                if (!empty($copyCartID)) {
                    Session::forget('cartCopy' . $copyCartID);
                    Session::forget('copyCartID');
                }
                //end
                return redirect()->route('cart.success', $orderID)->with('success', trans('index.OrderSuccess'));
            }
        } else if ($payment == 'MOMO') { //thanh toán qua momo
            $jsonResult = $this->momo_create($totalPrice, $orderID);
            if (!empty($jsonResult)) {
                if ($jsonResult['resultCode'] == 0) {
                    return Redirect::to($jsonResult['payUrl']);
                } else {
                    return Redirect::route('cart.checkout')->with('error', $jsonResult['message']);
                }
            } else {
                return Redirect::route('cart.checkout')->with('error', trans('index.TransactionFailed'));
            }
        } else if ($payment == 'VNPAY') { //thanh toán qua VNPAY
            $jsonResult = $this->vnpay_create($totalPrice, $orderID);
            return Redirect::to($jsonResult['data']);
        }
    }
    //vnpay
    public function vnpay_create($amount = 0, $orderID = 0)
    {
        $configVNPAY = $this->configVNPAY();
        $info_session =  Session::get('orderinfo');
        $vnp_TmnCode = $configVNPAY['TmnCode']; //Website ID in VNPAY System
        $vnp_HashSecret = $configVNPAY['HashSecret']; //Secret key
        $vnp_Url = $configVNPAY['Url'];
        $vnp_Returnurl = route('cart.VNPAYResult');
        $startTime = date("YmdHis");
        $expire = date('YmdHis', strtotime('+15 minutes', strtotime($startTime)));

        //data gửi đi
        //$vnp_TxnRef =  'VNPAY' . time() . ""; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_TxnRef =  $orderID; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderInfo = 'Thanh toan qua VNPAY';
        $vnp_OrderType = 'other';
        $vnp_Amount = $amount * 100;
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version
        $vnp_ExpireDate = $expire;
        //Billing
        $vnp_Bill_Mobile = $info_session['phone'];
        $vnp_Bill_Email = $info_session['email'];
        $fullName = trim($info_session['fullname']);
        if (isset($fullName) && trim($fullName) != '') {
            $name = explode(' ', $fullName);
            $vnp_Bill_FirstName = array_shift($name);
            $vnp_Bill_LastName = array_pop($name);
        }
        $vnp_Bill_City =  $info_session['city_id'];
        $vnp_Bill_Country = "VN";
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $vnp_ExpireDate,
            "vnp_Bill_Mobile" => $vnp_Bill_Mobile,
            "vnp_Bill_Email" => $vnp_Bill_Email,
            "vnp_Bill_FirstName" => $vnp_Bill_FirstName,
            "vnp_Bill_LastName" => $vnp_Bill_LastName,
            "vnp_Bill_City" => $vnp_Bill_City,
            "vnp_Bill_Country" => $vnp_Bill_Country,

        );
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = array(
            'code' => '00', 'message' => 'success', 'data' => $vnp_Url
        );
        return $returnData;
    }
    public function vnpay_result(Request $request)
    {
        $copyCartID = Session::get('copyCartID');
        $configVNPAY = $this->configVNPAY();
        $vnp_HashSecret = $configVNPAY['HashSecret']; //Secret key
        $vnp_SecureHash = $request->vnp_SecureHash;
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnp_TxnRef = (int)$request->vnp_TxnRef;
        $detailOrder = Order::select('id')->where('id', $vnp_TxnRef)->first();
        if ($secureHash == $vnp_SecureHash) {
            if ($request->vnp_ResponseCode == '00') {
                if ($detailOrder) {
                    $orderID = $detailOrder->id;
                } else {
                    $orderID = $vnp_TxnRef;
                }
                DB::table('orders_payment')->insert([
                    'order_id' => $orderID,
                    'transId' => $request->vnp_TransactionNo,
                    'json' => json_encode($request->query()),
                    'status' => 0,
                    'type' => 'VNPAY',
                    "created_at" => Carbon::now(),
                ]);
                Order::where('id', $orderID)->update(['publish' => 1]);
                $this->saveOrderItems($orderID);
                $this->saveCouponsRelationships($orderID);
                $this->sendMailOrder($orderID);
                //xóa session copy cart
                if (!empty($copyCartID)) {
                    Session::forget('cartCopy' . $copyCartID);
                    Session::forget('copyCartID');
                }
                //end
                return redirect()->route('cart.success', $orderID)->with('success', trans('index.OrderSuccess'));
            } else {
                Order::where('code', $detailOrder->id)->delete();
                if (!empty($copyCartID)) {
                    return Redirect::route('customer.copyOrder', ['id' => $copyCartID])->with('error',  trans('index.TransactionFailed'));
                } else {
                    return Redirect::route('cart.checkout')->with('error', trans('index.TransactionFailed'));
                }
            }
        } else {
            Order::where('code', $detailOrder->id)->delete();
            if (!empty($copyCartID)) {
                return Redirect::route('customer.copyOrder', ['id' => $copyCartID])->with('error', trans('index.InvalidSignature'));
            } else {
                return Redirect::route('cart.checkout')->with('error', trans('index.InvalidSignature'));
            }
        }
    }
    public function vnpay_ipn(Request $request)
    {
        $configVNPAY = $this->configVNPAY();

        $vnp_HashSecret = $configVNPAY['HashSecret']; //Secret key
        $inputData = array();
        $returnData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }
        $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        $vnpTranId = $inputData['vnp_TransactionNo']; //Mã giao dịch tại VNPAY
        $vnp_Amount = $inputData['vnp_Amount'] / 100; // Số tiền thanh toán VNPAY phản hồi
        try {
            //Check Orderid
            //Kiểm tra checksum của dữ liệu
            if ($secureHash == $vnp_SecureHash) {
                //Lấy thông tin đơn hàng lưu trong Database và kiểm tra trạng thái của đơn hàng, mã đơn hàng là: $orderId
                //Việc kiểm tra trạng thái của đơn hàng giúp hệ thống không xử lý trùng lặp, xử lý nhiều lần một giao dịch
                //Giả sử: $order = mysqli_fetch_assoc($result);
                $order = DB::table('orders_payment')->where('transId', $vnpTranId)->first();
                if ($order != NULL) {
                    $jsonOrder = json_decode($order->json, TRUE);
                    $order_Amount = $jsonOrder['vnp_Amount'] / 100;

                    if ($order_Amount == $vnp_Amount) //Kiểm tra số tiền thanh toán của giao dịch: giả sử số tiền kiểm tra là đúng. //$order["Amount"] == $vnp_Amount
                    {
                        if ($order->status != NULL && $order->status == 0) {
                            if ($request->vnp_ResponseCode == '00' || $request->vnp_TransactionStatus == '00') {
                                $Status = 1; // Trạng thái thanh toán thành công
                            } else {
                                $Status = 2; // Trạng thái thanh toán thất bại / lỗi
                            }
                            //Cài đặt Code cập nhật kết quả thanh toán, tình trạng đơn hàng vào DB
                            DB::table('orders_payment')->where('transId',  $order->transId)->update([
                                'status' => $Status,
                                "updated_at" => Carbon::now(),
                            ]);
                            //Trả kết quả về cho VNPAY: Website/APP TMĐT ghi nhận yêu cầu thành công
                            $returnData['RspCode'] = '00';
                            $returnData['Message'] = 'Confirm Success';
                        } else {
                            $returnData['RspCode'] = '02';
                            $returnData['Message'] = 'Order already confirmed';
                        }
                    } else {
                        $returnData['RspCode'] = '04';
                        $returnData['Message'] = 'invalid amount';
                    }
                } else {
                    $returnData['RspCode'] = '01';
                    $returnData['Message'] = 'Order not found';
                }
            } else {
                $returnData['RspCode'] = '97';
                $returnData['Message'] = 'Invalid signature';
            }
        } catch (\Exception $e) {
            $returnData['RspCode'] = '99';
            $returnData['Message'] = 'Unknow error';
        }
        //Trả lại VNPAY theo định dạng JSON
        echo json_encode($returnData);
    }
    //momo
    public function momo_create($amount = 0, $orderID = 0)
    {
        $configMOMO = $this->configMOMO();
        $orderCode = Order::select('code')->find($orderID);
        $endpoint = $configMOMO['endpoint'];
        $accessKey = $configMOMO['accessKey'];
        $secretKey = $configMOMO['secretKey'];
        $partnerCode = $configMOMO['partnerCode'];
        $orderInfo = "Thanh toán qua MoMo";
        $redirectUrl = route('cart.MOMOResult');
        $ipnUrl = route('cart.MOMOIPN');

        $amount = "$amount";
        // $orderId = 'MOMO' . time() . "";
        $orderId = $orderCode->code;
        $requestId = time() . "";
        $extraData = "";
        $requestType = 'payWithMethod';
        $partnerName = 'MoMo Payment';
        $storeId = 'Test Store';
        $orderGroupId = '';
        $autoCapture = True;
        $lang = 'vi';
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);
        $data = array(
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => 'MomoTestStore',
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'requestType' => $requestType,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'redirectUrl' => $redirectUrl,
            'autoCapture' => $autoCapture,
            'extraData' => $extraData,
            'orderGroupId' => $orderGroupId,
            'signature' => $signature
        );
        $result = execPostRequest($endpoint, json_encode($data));
        $jsonResult = json_decode($result, true);  // decode json

        return $jsonResult;
    }
    public function momo_result(Request $request)
    {
        $copyCartID = Session::get('copyCartID');
        $configMOMO = $this->configMOMO();
        $partnerCode = $configMOMO['partnerCode'];
        $accessKey = $configMOMO['accessKey'];
        $secretKey = $configMOMO['secretKey'];
        if ($request->resultCode == 0) {
            $requestId = $request->requestId;
            $amount = $request->amount;
            $orderId = $request->orderId;
            $orderInfo = $request->orderInfo;
            $extraData = "";
            $orderType = $request->orderType;
            $resultCode = $request->resultCode;
            $transId =  $request->transId;
            $message = $request->message;
            $responseTime = $request->responseTime;
            $resultCode = $request->resultCode;
            $payType = $request->payType;

            $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
                "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . $payType . "&requestId=" . $requestId . "&responseTime=" . $responseTime .
                "&resultCode=" . $resultCode . "&transId=" . $transId;
            $signature = hash_hmac("sha256", $rawHash, $secretKey);
            if ($signature == $request->signature) {
                if ($resultCode == '0') {
                    //lưu thông tin trả về vào bảng orders_payment
                    //luu thong tin vao bang orders_momo
                    $getOrderID = Order::select('id')->where('code', $orderId)->first();
                    DB::table('orders_payment')->insert([
                        'order_id' => $getOrderID->id,
                        'transId' => $request->transId,
                        'json' => json_encode($request->query()),
                        'status' => 0,
                        'type' => 'MOMO',
                        "created_at" => Carbon::now(),
                    ]);
                    Order::where('id', $getOrderID->id)->update(['publish' => 1]);
                    $this->saveOrderItems($getOrderID->id);
                    $this->saveCouponsRelationships($getOrderID->id);
                    $this->sendMailOrder($getOrderID->id);

                    return redirect()->route('cart.success', $getOrderID->id)->with('error', trans('index.OrderSuccess'));
                } else {
                    Order::where('code', $request->orderId)->delete();
                    if (!empty($copyCartID)) {
                        return Redirect::route('customer.copyOrder', ['id' => $copyCartID])->with('error', $message);
                    } else {
                        return Redirect::route('cart.checkout')->with('error',  $message);
                    }
                }
            } else {
                Order::where('code', $request->orderId)->delete();
                if (!empty($copyCartID)) {
                    return Redirect::route('customer.copyOrder', ['id' => $copyCartID])->with('error', "This transaction could be hacked, please check your signature and returned signature");
                } else {
                    return Redirect::route('cart.checkout')->with('error', "This transaction could be hacked, please check your signature and returned signature");
                }
            }
        } else {
            Order::where('code', $request->orderId)->delete();
            if (!empty($copyCartID)) {
                return redirect()->route('customer.copyOrder', ['id' => $copyCartID])->with('error', trans('index.TransactionAborted'));
            } else {
                return redirect()->route('cart.checkout')->with('error', trans('index.TransactionAborted'));
            }
        }
    }
    public function momo_ipn(Request $request)
    {
        $configMOMO = $this->configMOMO();
        $serectkey =  $configMOMO['secretKey'];
        $partnerCode = $request->partnerCode;
        $accessKey = $request->accessKey;
        $orderId = $request->orderId;
        $message = $request->message;
        $transId = $request->transId;
        $orderInfo = $request->orderInfo;
        $amount = $request->amount;
        $resultCode = $request->resultCode;
        $responseTime = $request->responseTime;
        $requestId = $request->requestId;
        $extraData = $request->extraData;
        $payType = $request->payType;
        $orderType = $request->orderType;
        $extraData = $request->extraData;
        $m2signature = $request->signature; //MoMo signature
        //Checksum
        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&message=" . $message . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo .
            "&orderType=" . $orderType . "&partnerCode=" . $partnerCode . "&payType=" . $payType . "&requestId=" . $requestId . "&responseTime=" . $responseTime .
            "&resultCode=" . $resultCode . "&transId=" . $transId;

        $partnerSignature = hash_hmac("sha256", $rawHash, $serectkey);
        $debugger = array();
        $debugger['rawData'] = $rawHash;
        $debugger['momoSignature'] = $m2signature;
        $debugger['partnerSignature'] = $partnerSignature;
        if ($m2signature == $partnerSignature) {
            if ($resultCode == '0') {
                //cap nhap du lieu dua vao transId(Mã giao dịch của MoMo)  orders_momo
                $response['message'] = "Capture Payment Success";
                DB::table('orders_payment')->where('transId', $request->transId)->update([
                    'status' => 1,
                    "updated_at" => Carbon::now(),
                ]);
            } else {
                $response['message'] =  $message;
            }
            $response['message'] = "Received payment result success";
        } else {
            $response['message'] = "ERROR! Fail checksum";
        }
        DB::table('orders_payment_logipn')->insert([
            'note' => $response['message'],
            'data' => json_encode($request),
            'type' => 'MOMO',
            "created_at" => Carbon::now(),
        ]);
        $response['debugger'] = $debugger;
        echo json_encode($response);
    }
    //lưu thông tin vào database
    public function saveOrder()
    {
        $info_session =  Session::get('orderinfo');
        $id = Order::insertGetId($info_session);
        $code = 'DH' . date('my') . $id;
        Order::where('id', $id)->update(['code' => $code, 'deleted_at' => '0000-00-00 00:00:00']);
        return $id;
    }
    //xử lý sau khi thanh toán thành công toán
    public function saveOrderItems($orderID = 0)
    {
        $info_session =  Session::get('orderinfo');
        $cart = json_decode($info_session['cart']);
        //lưu bảng order item
        $tmp_orderItem = [];
        if ($cart) {
            foreach ($cart as $v) {
                $tmp_orderItem[] = array(
                    "order_id" => $orderID,
                    "customer_id" => !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : 0,
                    "product_id" => $v->id,
                    "product_title" => $v->title,
                    "product_image" => $v->image,
                    "product_quantity" => $v->quantity,
                    "product_price" => $v->price,
                    "product_unit" => !empty($v->unit) ? $v->unit : '',
                    "product_option" => !empty($v->options) ? json_encode($v->options) : '',
                    "created_at" => Carbon::now(),
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
    }
    public function saveCouponsRelationships($orderID = 0)
    {
        $tmp_coupon = [];
        $info_session =  Session::get('orderinfo');
        //lưu vào bảng coupons_relationships
        $coupon = Session::get('coupon');
        if (!empty($coupon)) {
            foreach ($coupon as $v) {
                $tmp_coupon[] = array(
                    "orderid" => $orderID,
                    "coupon_id" => $v['id'],
                    "coupon_name" => $v['name'],
                    "email" => $info_session['email'],
                    "created_at" => Carbon::now(),
                );
            }
            DB::table('coupons_relationships')->insert($tmp_coupon);
        }
        //end
    }
    public function sendMailOrder($orderID = 0)
    {
        //xóa giỏ hàng
        Session::forget('cart');
        Session::forget('coupon');
        //xóa coupon
        Session::save();
        $fcSystem = $this->system->fcSystem();
        $info_session =  Session::get('orderinfo');
        //gui email
        $sendMail = array(
            'subject' => 'Thông báo! Đặt hàng thành công',
            'id' => $orderID,
        );
        Mail::to($fcSystem['contact_email'])->cc($info_session['email'])->send(new \App\Mail\SendMailCart($sendMail));
        //end
    }
}
