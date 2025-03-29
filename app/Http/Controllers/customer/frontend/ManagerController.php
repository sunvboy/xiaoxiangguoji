<?php

namespace App\Http\Controllers\customer\frontend;

use App\Components\Nestedsetbie;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Components\System;
use App\Models\Customer;
use App\Models\CustomerCategory;
use App\Models\CustomerLevel;
use App\Rules\PhoneNumber;
use Auth;
use Illuminate\Validation\Rule;
use Validator;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{
    protected $Nestedsetbie;
    protected $system;
    public function __construct()
    {
        $this->system = new System();
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'customer_categories'));
    }
    public function dashboard()
    {
        $fcSystem = $this->system->fcSystem();
        $detail =  Customer::find(Auth::guard('customer')->user()->id);
        $category = dropdown(CustomerCategory::orderBy('title', 'asc')->get(), 'Chọn lớp học', 'id', 'title');
        $customer_levels = dropdown(CustomerLevel::orderBy('order', 'asc')->get(), 'Chọn cấp bậc', 'title', 'title');
        $seo['meta_title'] = trans('index.AccountInformation');
        return view('customer/frontend/manager/information', compact('fcSystem', 'detail', 'seo', 'category', 'customer_levels'));
    }
    public function updateInformation(Request $request)
    {
        $id = Auth::guard('customer')->user()->id;
        $validator = Validator::make($request->all(), [
            // 'catalogue_id' => 'required|gt:0',
            'name' => 'required',
            'phone' => ['required', new PhoneNumber, Rule::unique('customers')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })],
            // 'address' => 'required',
        ], [
            // 'catalogue_id.required' => 'Lớp học là trường bắt buộc.',
            // 'catalogue_id.gt' => 'Lớp học là trường bắt buộc.',
            'name.required' => 'Họ và tên là trường bắt buộc.',
            'phone.required' => 'Số điện thoại là trường bắt buộc.',
            'phone.unique' => 'Số điện thoại đã tồn tại.',
            // 'address.required' => 'Địa chỉ là trường bắt buộc.',
        ]);
        if ($validator->passes()) {
            Customer::where('id', $id)->update(
                [
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'gender' => $request->gender,
                    'birthday' => $request->birthday,
                ]
            );
            return response()->json(['status' => 200]);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function storeChangePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'old_password' => 'required|string|min:6',
            'new_password' => 'required|string|min:6|required_with:old_password|same:old_password',
        ], [
            'current_password.required' => 'Mật khẩu cũ là trường bắt buộc.',
            'old_password.required' => 'Mật khẩu mới là trường bắt buộc.',
            'new_password.required' => 'Nhập lại mật khẩu mới là trường bắt buộc.',
            'new_password.required_with' => 'Mật khẩu mới và xác nhận mật khẩu mới phải giống nhau.',
            'new_password.same' => 'Mật khẩu mới và xác nhận mật khẩu mới phải giống nhau.',
        ]);
        if ($validator->passes()) {
            if (!Hash::check($request->current_password, Auth::guard('customer')->user()->password)) {
                return response()->json(['error' => "Mật khẩu cũ không chính xác"]);
            }
            $userId = Auth::guard('customer')->user()->id;
            Customer::where('id', $userId)->update(
                ['password' => bcrypt($request->new_password)]
            );
            return response()->json(['status' => 200]);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function coupons(Request $request)
    {
        $data = \App\Models\Coupon::where('deleted_at', '0000-00-00 00:00:00')->where('publish', 0)->orderBy('id', 'DESC');
        $data = $data->paginate(10);
        $fcSystem = $this->system->fcSystem();
        $seo['meta_title'] = "Danh sách mã giảm giá";
        return view('customer/frontend/manager/coupons', compact('fcSystem', 'seo', 'data'));
    }
}
