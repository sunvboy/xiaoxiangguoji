<?php

namespace App\Http\Controllers\cashbook;

use App\Http\Controllers\Controller;
use App\Models\ReceiptGroups;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;
use Validator;

class ReceiptGroupsController extends Controller
{
    protected $module = 'receipt_groups';
    public function __construct()
    {
        View::share(['module' => $this->module]);
    }
    public function index(Request $request)
    {
        $data = ReceiptGroups::where('id', '!=', 1)->orderBy('id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('code', 'like', '%' . $request->keyword . '%');
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        return view('cashbook.receipt.group.index', compact('data'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'code' => ['required', Rule::unique($this->module)],
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'code.required' => 'Mã là trường bắt buộc.',
            'code.unique' => 'Mã đã tồn tại.',
        ]);
        if ($validator->passes()) {
            $id = ReceiptGroups::insertGetId([
                'title' => $request->title,
                'code' => $request->code,
                'description' => $request->description,
                'userid_created' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['success' => 'Thêm mới loại phiếu thu thành công']);
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
        $detail = ReceiptGroups::find($id);
        if (!empty($detail)) {
            return response()->json(['data' => $detail]);
        } else {
            return response()->json(['error' => 'Loại phiếu thu không tồn tại']);
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
                'description' => $request->description,
                'updated_at' => Carbon::now()
            ];
            ReceiptGroups::find($id)->update($_data);
            return response()->json(['success' => 'Cập nhập loại phiếu thu thành công']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
}
