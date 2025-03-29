<?php

namespace App\Http\Controllers\customer\backend;

use App\Http\Controllers\Controller;
use App\Models\CustomerLevel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CustomerLevelController extends Controller
{
    protected $table = 'customer_levels';
    public function __construct()
    {
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data = CustomerLevel::orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $detail = [];
        if (!empty($request->id)) {
            $detail = CustomerLevel::find($request->id);
        }
        return view('customer.backend.level.index', compact('module', 'data', 'detail'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:customer_levels',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
        ]);
        $_data = [
            'title' => $request->title,
            'created_at' => Carbon::now(),
            'user_id' => Auth::user()->id
        ];
        CustomerLevel::create($_data);
        return redirect()->route('customer_levels.index')->with('success', "Thêm mới cấp bậc thành công");
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', Rule::unique('customer_levels')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })],
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
        ]);
        $_data = [
            'title' => $request->title,
            'created_at' => Carbon::now(),
            'user_id' => Auth::user()->id
        ];
        CustomerLevel::where('id', $id)->update($_data);
        return redirect()->route('customer_levels.index')->with('success', "Cập nhập cấp bậc thành công");
    }
}
