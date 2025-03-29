<?php

namespace App\Http\Controllers\suppliers;

use App\Exports\suppliers\SuppliersExport;
use App\Http\Controllers\Controller;
use App\Imports\suppliers\SuppliersImport;
use App\Models\Suppliers;
use App\Models\SuppliersCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;

class SuppliersController extends Controller
{
    protected $module = 'suppliers';
    public function __construct()
    {
        $categories = dropdown(SuppliersCategory::get(), 'Chọn nhóm nhà cung cấp', 'id', 'title');
        $listUsers = dropdown(\App\Models\User::orderBy('id', 'asc')->get(), 'Chọn nhân viên', 'id', 'name');
        $payments =  config('payment.method');
        View::share(['module' => $this->module, 'categories' => $categories, 'payments' => $payments, 'listUsers' => $listUsers]);
    }
    public function index(Request $request)
    {
        $user_id = $request->user_id;
        $category_id = $request->category_id;
        $publish = $request->publish;
        $payment = $request->payment;
        $keyword = $request->keyword;
        $data = Suppliers::orderBy('id', 'desc')->with('categories');
        if (is($keyword)) {
            $data =  $data->where('code', 'like', '%' . $keyword . '%')
                ->orWhere('title', 'like', '%' . $keyword . '%')
                ->orWhere('phone', 'like', '%' . $keyword . '%')
                ->orWhere('email', 'like', '%' . $keyword . '%');
        }
        if (is($payment)) {
            $data =  $data->where('payment', $payment);
        }
        if (is($user_id)) {
            $data =  $data->where('user_id', $user_id);
        }
        if (is($category_id)) {
            $data =  $data->where('category_id', $category_id);
        }
        if (!empty($publish)) {
            if ($publish != '-1') {
                $data =  $data->where('publish', 1);
            }
        } else {
            $data =  $data->where('publish', 0);
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($publish)) {
            $data->appends(['publish' => $publish]);
        }
        if (is($category_id)) {
            $data->appends(['category_id' => $category_id]);
        }
        if (is($user_id)) {
            $data->appends(['user_id' => $user_id]);
        }
        if (is($payment)) {
            $data->appends(['payment' => $payment]);
        }
        return view('suppliers.suppliers.index', compact('data'));
    }
    public function create()
    {
        $listCity = dropdown(\App\Models\VNCity::orderBy('id', 'asc')->get(), 'Tỉnh/Thành Phố', 'id', 'name');
        $listDistrict = dropdown(\App\Models\VNDistrict::where('ProvinceID', old('city_id'))->orderBy('name', 'asc')->get(), 'Quận/Huyện', 'id', 'name');
        $listWard = dropdown(\App\Models\VNWard::where('DistrictID', old('district_id'))->orderBy('name', 'asc')->get(), 'Phường/Xã', 'id', 'name');
        return view('suppliers.suppliers.create', compact('listCity', 'listDistrict', 'listWard'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'address' => 'required',
        ], [
            'title.required' => 'Tên nhà cung cấp là trường bắt buộc.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
        ]);
        $id = Suppliers::insertGetId([
            'title' => $request->title,
            'code' => $request->code,
            'category_id' => $request->category_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'label' => $request->label,
            'address' => $request->address,
            'city_id' => $request->city_id,
            'district_id' => $request->district_id,
            'ward_id' => $request->ward_id,
            'fax' => $request->fax,
            'taxNumber' => $request->taxNumber,
            'website' => $request->website,
            'debt' => str_replace('.', '', $request->debt),
            'user_id' => $request->user_id,
            'description' => $request->description,
            'payment' => $request->payment,
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ]);
        if ($id > 0) {
            return redirect()->route('suppliers.index')->with('success', "Thêm mới nhà cung cấp thành công");
        } else {
            return redirect()->route('suppliers.index')->with('error', "Thêm mới nhà cung cấp không thành công");
        }
    }
    public function edit($id)
    {
        $detail = Suppliers::find($id);
        if (!isset($detail)) {
            return redirect()->route('suppliers.index')->with('error', "Nhà cung cấp không tồn tại");
        }
        $listCity = dropdown(\App\Models\VNCity::orderBy('id', 'asc')->get(), 'Tỉnh/Thành Phố', 'id', 'name');
        $listDistrict = dropdown(\App\Models\VNDistrict::where('ProvinceID', !empty(old('city_id')) ? old('city_id') : (!empty($detail->city_id) ? $detail->city_id : ''))->orderBy('name', 'asc')->get(), 'Quận/Huyện', 'id', 'name');
        $listWard = dropdown(\App\Models\VNWard::where('DistrictID', !empty(old('district_id')) ? old('district_id') : (!empty($detail->district_id) ? $detail->district_id : ''))->orderBy('name', 'asc')->get(), 'Phường/Xã', 'id', 'name');
        return view('suppliers.suppliers.edit', compact('detail', 'listCity', 'listDistrict', 'listWard'));
    }

    public function update(Request $request, $id)
    {

        $request->validate([
            'title' => 'required',
            'address' => 'required',
        ], [
            'title.required' => 'Tên nhà cung cấp là trường bắt buộc.',
            'address.required' => 'Địa chỉ là trường bắt buộc.',
        ]);
        try {
            Suppliers::find($id)->update([
                'title' => $request->title,
                'code' => $request->code,
                'category_id' => $request->category_id,
                'phone' => $request->phone,
                'email' => $request->email,
                'label' => $request->label,
                'address' => $request->address,
                'city_id' => $request->city_id,
                'district_id' => $request->district_id,
                'ward_id' => $request->ward_id,
                'fax' => $request->fax,
                'taxNumber' => $request->taxNumber,
                'website' => $request->website,
                'debt' => str_replace('.', '', $request->debt),
                'user_id' => $request->user_id,
                'description' => $request->description,
                'payment' => $request->payment,
                'userid_created' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->route('suppliers.index')->with('success', "Thêm mới nhà cung cấp thành công");
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->route('suppliers.edit', ['id' => $id])->with('error', "Có lỗi xảy ra vui lòng thử lại");
        }
    }
    public function export(Request $request)
    {
        return Excel::download(new SuppliersExport, 'danh-sach-nha-cung-cap.xlsx');
    }
    public function import(Request $request)
    {
        Excel::import(new SuppliersImport, $request->file);
        return redirect()->route('suppliers.index')->with('success', 'Suppliers Imported Successfully');
    }
}
