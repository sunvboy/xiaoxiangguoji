<?php

namespace App\Http\Controllers\order\backend;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\orderConfig;
use App\Models\OrderPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $module = 'orders';
        $data = Order::where(['deleted_at' => '0000-00-00 00:00:00', 'publish' => 1])->orderBy('id', 'desc');
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
        if (is($request->customerid)) {
            $data =  $data->where('customerid', $request->customerid);
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
        if (is($request->customerid)) {
            $data->appends(['customerid' => $request->customerid]);
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
        $customers[0] = 'Chọn thành viên';
        $getCustomer = \App\Models\Customer::select('id', 'name', 'phone')->get();
        if (!$getCustomer->isEmpty()) {
            foreach ($getCustomer as $item) {
                $customers[$item->id] = $item->name . ' - ' . $item->phone;
            }
        }
        return view('order.backend.index', compact('module', 'data', 'customers'));
    }

    public function edit($id)
    {

        $module = 'orders';
        $detail = Order::with(['city_name', 'district_name', 'ward_name', 'order_returns'])->find($id);
        if (!isset($detail)) {
            return redirect()->route('orders.index')->with('error', "Đơn hàng không tồn tại");
        }
        return view('order.backend.edit', compact('module', 'detail'));
    }
    public function ajaxUploadStatus(Request $request)
    {
        $id = $request->id;
        Order::find($id)->update(['status' => $request->status]);
        $detail = Order::find($id);
        //ghi log
        \App\Models\OrderLog::insertGetId(array(
            'note' => 'Đổi trạng thái đơn hàng ' . '#' . $detail->code . ' thành "' . config('cart.status')[$request->status] . '"',
            'user_id' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now()
        ));
        //end
    }
    public function payment(Request $request)
    {
        $status = array(
            '0' => '<span class="btn btn-warning btn-sm text-white">Đang chờ</span>',
            '1' => '<span class="btn btn-success btn-sm text-white">Thành công</span>',
            '2' => '<span  class="btn btn-danger btn-sm text-white">Thất bại/lỗi</span>'
        );
        $module = 'orders_payment';
        $data = OrderPayment::with('getOrder')->orderBy('id', 'desc');
        if (is($request->date)) {
            $date =  explode(' to ', $request->date);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('created_at', '>=', $date_start)->where('created_at', '<=', $date_end);
            }
        }
        $data = $data->paginate(env('APP_paginate'));

        if (is($request->date)) {
            $data->appends(['date' => $request->date]);
        }
        return view('order.payment.index', compact('module', 'data', 'status'));
    }
    public function configOrder(Request $request)
    {
        $module = 'order_configs';
        if (env('APP_ENV') == "local") {
            $data = \App\Models\orderConfig::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        } else {
            $data = \App\Models\orderConfig::where('id', '!=', 3)->where('id', '!=', 4)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        }
        return view('order.config.index', compact('module', 'data'));
    }
    public function configOrderEdit($id)
    {
        $module = 'orders';
        if (env('APP_ENV') == "local") {
            $detail = \App\Models\orderConfig::find($id);
        } else {
            $detail = \App\Models\orderConfig::where('id', '!=', 3)->where('id', '!=', 4)->find($id);
        }
        if (!isset($detail)) {
            return redirect()->route('orders.config')->with('error', "Thanh toán không tồn tại");
        }
        return view('order.config.edit', compact('module', 'detail'));
    }
    public function configOrderUpdate(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
        ]);
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'orders');
        } else {
            $image_url = $request->image_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
        ];
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('orders.config')->with('success', "Cập nhập thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $arrayImg = [])
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        $_data = [
            'title' => $request['title'],
            'description' => $request['description'],
            'image' =>  $arrayImg['image_url'],
            'config' =>  json_encode($request['config']),
            'publish' => $request['publish'],
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = orderConfig::insertGetId($_data);
        } else {
            orderConfig::find($id)->update($_data);
        }
    }
    public function returns(Request $request)
    {
        $module = 'orders';
        $data = Order::select('orders.id', 'orders.code', 'orders.fullname', 'orders.phone', 'orders.email', 'orders.total_price', 'orders.total_price_coupon', 'orders.fee_ship', 'orders.payment', 'order_returns.cart', 'order_returns.status')
            ->where(['orders.deleted_at' => '0000-00-00 00:00:00', 'orders.publish' => 1, 'orders.status' => 'returns'])
            ->join('order_returns', 'order_returns.order_id', '=', 'orders.id')
            ->orderBy('order_returns.status', 'asc')
            ->orderBy('order_returns.id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->where('orders.code', 'like', '%' . $request->keyword . '%')
                ->orWhere('orders.fullname', 'like', '%' . $request->keyword . '%')
                ->orWhere('orders.phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('orders.email', 'like', '%' . $request->keyword . '%');
        }
        if ($request->status != '') {
            $data =  $data->where('order_returns.status', $request->status);
        }
        if (is($request->date)) {
            $date =  explode(' to ', $request->date);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('order_returns.created_at', '>=', $date_start)->where('order_returns.created_at', '<=', $date_end);
            }
        }
        if (is($request->customerid)) {
            $data =  $data->where('customerid', $request->customerid);
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        if (is($request->customerid)) {
            $data->appends(['customerid' => $request->customerid]);
        }
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->date)) {
            $data->appends(['date' => $request->date]);
        }
        $customers[0] = 'Chọn thành viên';
        $getCustomer = \App\Models\Customer::select('id', 'name', 'phone')->get();
        if (!$getCustomer->isEmpty()) {
            foreach ($getCustomer as $item) {
                $customers[$item->id] = $item->name . ' - ' . $item->phone;
            }
        }
        return view('order.backend.return', compact('module', 'data', 'customers'));
    }
    public function returnsEdit(Request $request)
    {
        $alert = array(
            'error' => '',
            'message' => '',
            'status' => 200,
        );
        $html = '';
        $id = $request->id;
        $detail = \App\Models\Order::with('order_returns')->find($id);
        if (!isset($detail)) {
            $alert['error'] = 'Đơn hàng không tồn tại';
            $alert['status'] = 500;
        }
        $cart = json_decode($detail->order_returns->cart, TRUE);
        $html = '<div class="listCart space-y-3 scrollbar">';
        $totalReturn = 0;
        $quantityReturn = 0;
        if (!empty($cart)) {
            foreach ($cart as $key => $item) {
                $slug = !empty($item['slug']) ? $item['slug'] : '';
                $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
                if (!empty($item['quantity_return'])) {
                    $totalReturn =  $totalReturn + ($item['price'] * $item['quantity_return']);
                    $quantityReturn =  $quantityReturn + $item['quantity_return'];
                    $unit = !empty($item['unit']) ? $item['unit'] : 'sản phẩm';
                    $html .= '<input type="hidden" name="order_id" value="' . $detail->id . '"><div class="flex flex-col md:flex-row items-center py-4 first:pt-0 last:border-0 last:pb-0 border-b border-dashed border-slate-200 dark:border-darkmode-400">
                        <div class="flex items-center md:mr-auto flex-1">
                            <div class="image-fit w-16 h-16">
                                <img src="' . url($item['image']) . '" class="rounded-lg border-2 border-white shadow-md" alt="' . $item['title'] . '">
                            </div>
                            <div class="ml-5">
                                <div class="font-bold text-danger">' . $item['title'] . '</div>
                                <div>
                                    ' . $title_version . '
                                </div>
                                <div class="text-slate-500 mt-1">Hoàn trả: ' . $item['quantity_return'] . ' ' . $unit . ' x
                                    ' . number_format($item['price'], 0, ',', '.') . '₫
                                </div>

                            </div>
                        </div>
                        <div class="py-4 md:pl-12 md:pr-10 md:border-l text-center md:text-left border-dashed border-slate-200 dark:border-darkmode-400" style="width:200px">
                            <div class="text-slate-500">Thành tiền</div>
                            <div class="font-medium mt-1">' . number_format($item['price'] * $item['quantity_return'], 0, ',', '.') . '₫
                            </div>
                        </div>
                    </div>';
                }
            }
            $html .= '</div><div class="overflow-x-auto">
                                <table class="table">
                                    <tbody>
                                      
                                        <tr>
                                            <td class="border-b dark:border-darkmode-400">
                                                <div class="font-medium whitespace-nowrap">Tổng tiền</div>
                                            </td>
                                            <td class="text-right border-b dark:border-darkmode-400  font-medium">' . number_format($totalReturn, 0, ',', '.') . '₫</td>
                                        </tr>
                                        <tr>
                                            <td class="border-b dark:border-darkmode-400">
                                                <div class="font-medium whitespace-nowrap">Tổng tiền có thể hoàn</div>
                                            </td>
                                            <td class="text-right border-b dark:border-darkmode-400  font-medium">' . number_format($detail->total_price - $detail->total_price_coupon, 0, ',', '.') . '₫</td>
                                        </tr>
                                      <tr>
                                            <td class="border-b dark:border-darkmode-400">
                                                <div class="font-medium whitespace-nowrap">Hoàn trả cho đơn hàng</div>
                                            </td>
                                            <td class="text-right border-b dark:border-darkmode-400  font-medium">
                                            <input name="price_return" style="border: 1px solid #dddddd;text-align: right;" class="form-control w-full title p-2 int price" value="' . number_format($totalReturn, 0, ',', '.') . '"></td>
                                        </tr>
                                         <tr>
                                            <td class="border-b dark:border-darkmode-400">
                                                <div class="font-medium whitespace-nowrap"></div>
                                            </td>
                                            <td class="text-right border-b dark:border-darkmode-400  font-medium">
                                            <input type="checkbox" name="return_stock" value="1">
                                            Hoàn kho ' . $quantityReturn . ' sản phẩm
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>';
        }

        return response()->json(['data' => $alert, 'html' => $html]);
    }
    public function returnsUpdate(Request $request)
    {
        $return_stock = $request->return_stock;
        $order_id = $request->order_id;
        $totalPrice = 0;
        $oldPrice = 0;
        $detail = \App\Models\Order::where('id', $order_id)->first();
        $detailCustomer = \App\Models\Customer::select('id', 'price', 'name')->where('id', $detail->customerid)->first();
        if (!empty($detailCustomer->id)) {
            $oldPrice = $detailCustomer->price;
            $totalPrice = $totalPrice + $detailCustomer->price + (float)str_replace('.', '', $request->price_return);
        }
        // cấp nhập trạng thái
        \App\Models\OrderReturn::where('order_id', $detail->id)->update(array(
            'status' => 1,
            'price_return' => str_replace('.', '', $request->price_return),
            'updated_at' => Carbon::now(),
        ));
        //update tiền cho khách hoàng
        \App\Models\Customer::where('id', $detail->customerid)->update(array('price' => $totalPrice));
        //cập nhập số lượng tồn kho
        if (!empty($return_stock)) {
            $cart = json_decode($detail->order_returns->cart, TRUE);
            if (!empty($cart)) {
                foreach ($cart as $item) {
                    $id_version = !empty($item['options']['id_version']) ? $item['options']['id_version'] : '';
                    if (!empty($item['options']) && !empty($id_version)) {
                        $check = \App\Models\ProductVersion::where('id_version', $id_version)->first();
                        if ($check) {
                            if ($check->_stock_status == 1 && $check->_outstock_status  == 0) {
                                \App\Models\ProductVersion::where('id_version', $id_version)->update(array(
                                    '_stock' => $check->_stock + (int)$item['quantity_return']
                                ));
                            }
                        }
                    } else {
                        $check = \App\Models\Product::where('id', $item['id'])->first();
                        if ($check) {
                            if ($check->inventory == 1 && $check->inventoryPolicy == 0) {
                                \App\Models\Product::where('id', $check->id)->update(array(
                                    'inventoryQuantity' => $check->inventoryQuantity + (int)$item['quantity_return']
                                ));
                            }
                        }
                    }
                }
            }
        }
        //END
        //ghi log đơn hàng
        \App\Models\OrderLog::insertGetId(array(
            'note' => 'Hoàn trả đơn hàng ' . '#' . $detail->code . ' số tiền ' . $request->price_return . 'đ',
            'user_id' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now()
        ));
        //end
        //ghi log cộng tiền
        \App\Models\CustomerLog::insertGetId(array(
            'note' => $detailCustomer->name . ' <span style="color:green;font-weight:bold">+ ' . $request->price_return . 'đ</span> ' . 'hoàn/trả đơn hàng #' . $detail->code,
            'customer_id' => $detailCustomer->id,
            'oldPrice' => $oldPrice,
            'finalPrice' => $totalPrice,
            'user_id' => Auth::user()->id,
            'created_at' => \Carbon\Carbon::now()
        ));
        //end
        return response()->json(['status' => 200]);
    }
    public function export()
    {
        return Excel::download(new OrderExport, 'danh-sach-don-hang.xlsx');
    }
}
