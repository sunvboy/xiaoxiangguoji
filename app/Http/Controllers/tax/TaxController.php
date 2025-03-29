<?php

namespace App\Http\Controllers\tax;

use App\Http\Controllers\Controller;
use App\Models\Tax;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class TaxController extends Controller
{
    protected $module = 'taxes';
    public function index()
    {
        $module = $this->module;
        $data = Tax::orderBy('value', 'desc')->where('id', '!=', 1)->get();
        $config = Tax::where('id', 1)->first();
        return view('taxes.index', compact('module', 'data', 'config'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'value' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'value.required' => 'Thuế suất là trường bắt buộc.',
        ]);
        if ($validator->passes()) {
            $id = Tax::insertGetId([
                'title' => $request->title,
                'code' => $request->code,
                'value' => $request->value,
                'user_id' => Auth::user()->id,
                'created_at' => Carbon::now()
            ]);
            if ($id > 0) {
                return response()->json(['success' => 'Thêm mới thuế thành công']);
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
        $detail = Tax::find($id);
        if (!empty($detail)) {
            return response()->json(['data' => $detail]);
        } else {
            return response()->json(['error' => 'Thuế không tồn tại']);
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
            'value' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'value.required' => 'Thuế suất là trường bắt buộc.',
        ]);
        if ($validator->passes()) {
            $_data = [
                'title' => $request->title,
                'code' => $request->code,
                'value' => $request->value,
                'updated_at' => Carbon::now()
            ];
            Tax::find($id)->update($_data);
            return response()->json(['success' => 'Cập nhập thuế thành công']);
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function config(Request $request)
    {
        $taxSale = $request->taxSale;
        $taxPurchase = $request->taxPurchase;
        $active = $request->active;
        if (!empty($taxSale)) {
            DB::table('taxes')->update(['taxSale' => 0]);
            Tax::where('id', $taxSale)->update(['taxSale' => 1]);
        }
        if (!empty($taxPurchase)) {
            DB::table('taxes')->update(['taxPurchase' => 0]);
            Tax::where('id', $taxPurchase)->update(['taxPurchase' => 1]);
        }
        if (!empty($active)) {
            Tax::where('id', 1)->update(['active' => $active]);
        }
        return response()->json(['success' => 'Cập nhập thành công']);
    }
}
