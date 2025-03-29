<?php

namespace App\Http\Controllers\customer\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Validator;
use Carbon\Carbon;
use App\Components\System;
use Form;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function index()
    {
        $id = Auth::guard('customer')->user()->id;
        $fcSystem = $this->system->fcSystem();
        $data = \App\Models\CustomerAddress::where('customer_id', $id)->with(['city_name', 'district_name', 'ward_name'])->orderBy('publish', 'desc')->orderBy('id', 'desc')->get();
        $getCity = \App\Models\VNCity::orderBy('name', 'asc')->get();
        $listCity[''] = trans('index.City');
        if (isset($getCity)) {
            foreach ($getCity as $key => $val) {
                $listCity[$val->id] = $val->name;
            }
        }
        $seo['meta_title'] = trans('index.ContactInformation');
        return view('customer/frontend/manager/address', compact('fcSystem', 'seo', 'data', 'listCity'));
    }
    public function show(Request $request)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $id = $request->id;
        $detail = \App\Models\CustomerAddress::where(['id' => $id, 'customer_id' => $customer_id])->first();
        if (!isset($detail)) {
            return response()->json(['error' => 'ERROR']);
        }
        $getCity = \App\Models\VNCity::orderBy('name', 'asc')->get();
        $getDistrict = \App\Models\VNDistrict::where('ProvinceID', $detail->city_id)->orderBy('name', 'asc')->get();
        $getWard = \App\Models\VNWard::where('DistrictID', $detail->district_id)->orderBy('name', 'asc')->get();
        $listCity[''] = trans('index.City');
        $listDistrict[''] = trans('index.District');
        $listWard[''] = trans('index.Ward');
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


        $html = '';
        $html .= '<form id="form-updateAddress" class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" action="' . route('customer.updateAddress', ['id' => $detail->id]) . '">
                <h3 class="text-black font-bold text-xl">Sửa sổ địa chỉ</h3>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg text-sm" style="display: none">
                    <strong class="font-bold">ERROR!</strong>
                    <span class="block sm:inline"></span>
                </div>
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg text-sm" style="display: none">
                    <div class="flex items-center">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold"></span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">' . trans('index.Fullname') . '</label>
                        <input type="text" name="name" id="name" value="' . $detail->name . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="">
                    </div>
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">' . trans('index.Phone') . '</label>
                        <input type="text" name="phone" id="phone" value="' . $detail->phone . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="cityID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">' . trans('index.City') . '</label>
                        ' . Form::select('city_id', $listCity, $detail->city_id, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white', 'id' => 'cityEdit']) . '
                    </div>
                    <div>
                        <label for="districtID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">' . trans('index.District') . '
                        </label>
                        ' . Form::select('district_id', $listDistrict, $detail->district_id, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white', 'id' => 'districtEdit', 'placeholder' => trans('index.District')]) . '
                    </div>
                    <div>
                        <label for="wardID" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">' . trans('index.Ward') . '</label>
                        ' . Form::select('ward_id', $listWard, $detail->ward_id, ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white', 'id' => 'wardEdit', 'placeholder' => trans('index.Ward')]) . '
                    </div>
                    <div>
                        <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">' . trans('index.DeliveryAddress') . '
                        </label>
                        <input type="text" name="address" id="address" value="' . $detail->address . '" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white" placeholder="Ví dụ: 1205 E1, Gold Park, 122, Phố Trung Kính">
                    </div>
                </div>
                <div class="flex items-center w-full mb-12">
                    <label for="toogleAEdit" class="flex items-center cursor-pointer">
                        <div class="relative">';
        if (!empty($detail->publish)) {
            $html .= '<input id="toogleAEdit" type="checkbox" class="sr-only" name="publish" value="1" checked />';
        } else {
            $html .= '<input id="toogleAEdit" type="checkbox" class="sr-only" name="publish" value="0" />';
        }

        $html .= '<div class="w-10 h-[24px] bg-gray-400 rounded-full shadow-inner"></div>
                            <div class="dot absolute w-6 h-6 bg-white rounded-full shadow -left-1 top-0 transition"></div>
                        </div>
                        <div class="ml-3 text-gray-700 text-sm">
                            ' . trans('index.SetDefaultAddress') . '
                        </div>
                    </label>
                </div>
                <button type="submit" class="js_update_address text-white bg-global hover:bg-rose-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-global dark:hover:bg-rose-600 dark:focus:ring-blue-800">' . trans('index.UpdateNewAddress') . '</button>
            </form>';
        return response()->json(['html' => $html, 'error' => '']);
    }
    public function store(Request $request)
    {
        if (config('app.locale') == 'vi') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => ['required', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
                'address' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'ward_id' => 'required',
            ], [
                'name.required' => 'Họ và tên là trường bắt buộc.',
                'phone.required' => 'Số điện thoại là trường bắt buộc.',
                'phone.unique' => 'Số điện thoại đã tồn tại.',
                'phone.regex'        => 'Số điện thoại không hợp lệ.',
                'phone.numeric' => 'Số điện thoại không đúng định dạng.',
                'address.required' => 'Địa chỉ là trường bắt buộc.',
                'city_id.required' => 'Tỉnh/Thành phố là trường bắt buộc.',
                'district_id.required' => 'Quận/Huyện là trường bắt buộc.',
                'ward_id.required' => 'Phường/Xã là trường bắt buộc.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => ['required', 'unique:customers', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
                'address' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'ward_id' => 'required',
            ]);
        }
        if ($validator->passes()) {
            $_data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
                'publish' => !empty($request->publish) ? 1 : 0,
                'customer_id' => Auth::guard('customer')->user()->id,
                'created_at' => Carbon::now(),
            ];
            $id = \App\Models\CustomerAddress::insertGetId($_data);
            if (!empty($id)) {
                if (!empty($request->publish)) {
                    \App\Models\CustomerAddress::where('id', '!=', $id)->where('customer_id', Auth::guard('customer')->user()->id)->update(array('publish' => 0));
                }
                return response()->json(['status' => 200]);
            } else {
                return response()->json(['error' => "ERROR"]);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function update(Request $request, $id)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $detail = \App\Models\CustomerAddress::where(['id' => $id, 'customer_id' => $customer_id])->first();
        if (!isset($detail)) {
            return response()->json(['error' => 'ERROR']);
        }
        if (config('app.locale') == 'vi') {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => ['required', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
                'address' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'ward_id' => 'required',
            ], [
                'name.required' => 'Họ và tên là trường bắt buộc.',
                'phone.required' => 'Số điện thoại là trường bắt buộc.',
                'phone.unique' => 'Số điện thoại đã tồn tại.',
                'phone.regex'        => 'Số điện thoại không hợp lệ.',
                'phone.numeric' => 'Số điện thoại không đúng định dạng.',
                'address.required' => 'Địa chỉ là trường bắt buộc.',
                'city_id.required' => 'Tỉnh/Thành phố là trường bắt buộc.',
                'district_id.required' => 'Quận/Huyện là trường bắt buộc.',
                'ward_id.required' => 'Phường/Xã là trường bắt buộc.',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'phone' => ['required', 'unique:customers', 'numeric', 'regex:/^(03|02|05|07|08|09|01[2|6|8|9])+([0-9]{8})$/'],
                'address' => 'required',
                'city_id' => 'required',
                'district_id' => 'required',
                'ward_id' => 'required',
            ]);
        }
        if ($validator->passes()) {
            $_data = [
                'name' => $request->name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
                'publish' => !empty($request->publish) ? 1 : 0,
                'updated_at' => Carbon::now(),
            ];
            \App\Models\CustomerAddress::where(['id' => $id, 'customer_id' => $customer_id])->update($_data);
            if (!empty($request->publish)) {
                \App\Models\CustomerAddress::where('id', '!=', $id)->where('customer_id', $customer_id)->update(array('publish' => 0));
            }
            return response()->json(['status' => 200]);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function delete(Request $request)
    {
        $customer_id = Auth::guard('customer')->user()->id;
        $id = $request->id;
        $detail = \App\Models\CustomerAddress::where(['id' => $id, 'customer_id' => $customer_id])->first();
        if (!isset($detail)) {
            return response()->json(['error' => 'ERROR']);
        }
        \App\Models\CustomerAddress::where(['id' => $id, 'customer_id' => $customer_id])->delete();
        if ($detail->publish == 1) {
            $itemLastChild = \App\Models\CustomerAddress::select('id')->where(['customer_id' => $customer_id])->orderBy('id', 'desc')->first();
            if ($itemLastChild) {
                \App\Models\CustomerAddress::where(['id' => $itemLastChild->id, 'customer_id' => $customer_id])->update(array('publish' => 1));
            }
        }
        return response()->json(['status' => 200]);
    }
}
