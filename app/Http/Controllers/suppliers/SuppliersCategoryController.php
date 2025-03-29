<?php

namespace App\Http\Controllers\suppliers;

use App\Http\Controllers\Controller;
use App\Models\SuppliersCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Validator;

class SuppliersCategoryController extends Controller
{
    protected $module = 'suppliers_categories';
    public function __construct()
    {
        View::share(['module' => $this->module]);
    }
    public function index(Request $request)
    {
        $data = SuppliersCategory::orderBy('id', 'desc')->with('counts');
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . removeutf8($request->keyword) . '%')
                ->orWhere('code', 'like', '%' . removeutf8($request->keyword) . '%');
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        return view('suppliers.category.index', compact('data'));
    }


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
        ]);
        if ($validator->passes()) {
            $id = SuppliersCategory::insertGetId([
                'title' => $request->title,
                'code' => $request->code,
                'description' => $request->description,
                'userid_created' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['success' => 'Thêm mới nhóm nhà cung cấp thành công']);
            } else {
                return response()->json(['error' => 'Có lỗi xảy ra vui lòng thử lại']);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }



    public function edit(Request $request)
    {
        $id = $request->id;
        if (empty($id)) {
            return response()->json(['error' => 'Có lỗi xảy ra vui lòng thử lại']);
        }
        $detail = SuppliersCategory::find($id);
        if (!empty($detail)) {
            return response()->json(['data' => $detail]);
        } else {
            return response()->json(['error' => 'Nhóm nhà cung cấp không tồn tại']);
        }
    }


    public function update(Request $request)
    {
        $id = $request->id;
        if (empty($id)) {
            return response()->json(['error' => 'Có lỗi xảy ra vui lòng thử lại']);
        }
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
        ]);
        if ($validator->passes()) {
            $_data = [
                'title' => $request->title,
                'code' => $request->code,
                'description' => $request->description,
                'updated_at' => Carbon::now()
            ];
            SuppliersCategory::find($id)->update($_data);
            return response()->json(['success' => 'Cập nhập nhóm nhà cung cấp thành công']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
