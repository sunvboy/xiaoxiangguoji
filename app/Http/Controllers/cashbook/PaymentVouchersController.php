<?php

namespace App\Http\Controllers\cashbook;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\PaymentGroups;
use App\Models\PaymentVouchers;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class PaymentVouchersController extends Controller
{
    protected $module = 'payment_vouchers';
    public function __construct()
    {
        $status = array(
            'method' => ['0' => 'Chọn trạng thái', 'completed' => 'Hoàn thành', 'cancelled' => 'Đã hủy'],
            'class' => ['completed' => 'btn btn-success btn-sm text-white', 'cancelled' => 'btn btn-danger btn-sm text-white']
        );
        $categories = dropdown(PaymentGroups::where('id', '!=', 11)->get(), 'Chọn loại phiếu chi', 'id', 'title');
        $address = \App\Models\Address::select('id', 'title', 'active')->orderBy('active', 'desc')->get();
        $dropdown = getFunctions();
        $table = array(
            '0' => 'Nhóm người nhận',
            'customers' => 'Khách hàng',
            'users' => 'Nhân viên',
            'product_purchases' => 'Đơn nhập hàng',
            'suppliers' => 'Nhà cung cấp',
            'ships' => 'Đối tác vận chuyển',
            'other' => 'Đối tượng khác',
        );
        View::share(['module' => $this->module, 'categories' => $categories, 'address' => $address, 'dropdown' => $dropdown, 'table' => $table, 'status' => $status]);
    }
    public function index(Request $request)
    {
        $module = $request->module;
        $created_at = $request->created_at;
        $keyword = $request->keyword;
        $data = PaymentVouchers::select('payment_vouchers.*')->orderBy('payment_vouchers.id', 'desc')->with(['payment_groups', 'product_purchases', 'users', 'customers']);
        if (is($module)) {
            $data =  $data->where('payment_vouchers.module', $module);
        }
        if (is($keyword)) {
            $data = $data->where('payment_vouchers.code', 'like', '%' . $keyword . '%')
                ->orWhere('payment_vouchers.reference', 'like', '%' . $keyword . '%')
                ->orWhere('payment_vouchers.description', 'like', '%' . $keyword . '%')
                ->orWhere('product_purchases.code', 'like', '%' . $keyword . '%')
                ->join('product_purchases', 'payment_vouchers.module_id', '=', 'product_purchases.id');
        }
        if (is($created_at)) {
            $date =  explode(' to ', $created_at);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('payment_vouchers.created_at', '>=', $date_start)->where('payment_vouchers.created_at', '<=', $date_end);
            }
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($created_at)) {
            $data->appends(['keyword' => $created_at]);
        }
        if (is($module)) {
            $data->appends(['keyword' => $module]);
        }
        $users = dropdown(\App\Models\User::select('id', 'name')->orderBy('name', 'asc')->get(), 'Chọn người tạo', 'id', 'name');

        return view('cashbook.payment.payment.index', compact('data', 'users'));
    }

    public function create()
    {
        $table = old('module');
        $loadModule = $this->loadModule($table);
        $data = [];
        if (!empty($table)) {
            if (!empty($loadModule) && count($loadModule['data']) > 0) {
                $data = $loadModule['data'];
            }
        } else {
            $data = \App\Models\Customer::select('id', 'name as title', 'phone')->get();
        }
        return view('cashbook.payment.payment.create', compact('data'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required',
            'code' => ['required', Rule::unique($this->module)],
            'price' => 'required',
            'type' => 'required',
        ], [
            'module.required' => 'Nhóm người nhận là trường bắt buộc.',
            'code.required' => 'Mã phiếu là trường bắt buộc.',
            'code.unique' => 'Mã phiếu đã tồn tại.',
            'price.required' => 'Giá trị là trường bắt buộc.',
            'type.required' => 'Hình thức thanh toán là trường bắt buộc.',
        ]);
        $id = PaymentVouchers::insertGetId([
            'module' => $request->module,
            'module_id' => !empty($request->module_id) ? $request->module_id : '',
            'group_id' => !empty($request->group_id) ? $request->group_id : 12,
            'code' => !empty($request->code) ? $request->code : '',
            'price' =>  str_replace('.', '', $request->price),
            'type' => !empty($request->type) ? $request->type : 0,
            'reference' => !empty($request->reference) ? $request->reference : '',
            'checked' => !empty($request->checked) ? $request->checked : 0,
            'address_id' => !empty($request->address_id) ? $request->address_id : '',
            'description' => !empty($request->description) ? $request->description : '',
            'userid_created' => Auth::user()->id,
            'created_at' => Carbon::now(),
            'status' => 'completed'
        ]);
        if ($id > 0) {
            return redirect()->route('payment_vouchers.index')->with('success', "Thêm mới phiếu chi thành công");
        } else {
            return redirect()->route('payment_vouchers.create')->with('error', "Thêm mới phiếu chi không thành công");
        }
    }
    public function edit($id)
    {
        $detail = PaymentVouchers::find($id);
        if (!isset($detail)) {
            return redirect()->route('payment_vouchers.index')->with('error', "Phiếu chi không tồn tại");
        }
        $table = $detail->module;

        if ($table == 'product_purchases') {
            $data = \App\Models\ProductPurchase::select('id', 'code as title')->get();
        } else {
            $loadModule = $this->loadModule($table);
            $data = [];
            if (!empty($table)) {
                if (!empty($loadModule) && count($loadModule['data']) > 0) {
                    $data = $loadModule['data'];
                }
            } else {
                $data = \App\Models\Customer::select('id', 'name as title', 'phone')->get();
            }
        }



        return view('cashbook.payment.payment.edit', compact('detail', 'data'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => ['required', Rule::unique($this->module)->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })], 'type' => 'required',
        ], [
            'code.required' => 'Mã phiếu là trường bắt buộc.',
            'code.unique' => 'Mã phiếu đã tồn tại.',
            'type.required' => 'Hình thức thanh toán là trường bắt buộc.',

        ]);
        try {
            PaymentVouchers::where('id', $id)->update([
                'code' => !empty($request->code) ? $request->code : '',
                'reference' => !empty($request->reference) ? $request->reference : '',
                'type' => !empty($request->type) ? $request->type : '',
                'description' => !empty($request->description) ? $request->description : '',
                'userid_updated' => Auth::user()->id,
                'updated_at' => Carbon::now(),
            ]);
            return redirect()->route('payment_vouchers.index')->with('success', "Cập nhập phiếu chi thành công");
        } catch (ModelNotFoundException $exception) {
            return back()->withError($exception->getMessage())->withInput();
        }
    }
    public function getModule(Request $request)
    {
        $table = $request->table;
        $data = $this->loadModule($table);
        $html = '';
        if (!empty($data) && !empty($data['html'])) {
            $html .= $data['html'];
        }
        if (!empty($data) && count($data['data']) > 0) {
            foreach ($data['data'] as $item) {
                $title = $item['title'] . (!empty($item['phone']) ? '-' . $item['phone'] : '');
                $html .= '<option value="' . $item['id'] . '">' . $title . '</option>';
            }
        }
        return response()->json(['html' => $html]);
    }
    public function ajaxSearch(Request $request)
    {
        $module = $request->module;
        $created_at = $request->created_at;
        $keyword = $request->keyword;
        $type = $request->type;
        $group_id = $request->group_id;
        $address_id = $request->address_id;
        $userid_created = $request->userid_created;
        $status = $request->status;
        $checked = $request->checked;
        $data = PaymentVouchers::select('payment_vouchers.*')->orderBy('payment_vouchers.id', 'desc')->with(['payment_groups', 'product_purchases', 'users', 'customers']);
        if (is($module)) {
            $data =  $data->whereIn('payment_vouchers.module', $module);
        }
        if (is($type)) {
            $data =  $data->whereIn('payment_vouchers.type', $type);
        }
        if (is($group_id)) {
            $data =  $data->whereIn('payment_vouchers.group_id', $group_id);
        }
        if (is($address_id)) {
            $data =  $data->whereIn('payment_vouchers.address_id', $address_id);
        }
        if (is($userid_created)) {
            $data =  $data->where('payment_vouchers.userid_created', $userid_created);
        }
        if (is($status)) {
            $data =  $data->where('payment_vouchers.status', $status);
        }
        if (!empty($checked)) {
            if ($checked != '-1') {
                $data =  $data->where('checked', 1);
            }
        } else {
            $data =  $data->where('checked', 0);
        }
        if (is($keyword)) {
            $data = $data->where('payment_vouchers.code', 'like', '%' . $keyword . '%')
                ->orWhere('payment_vouchers.reference', 'like', '%' . $keyword . '%')
                ->orWhere('product_purchases.code', 'like', '%' . $keyword . '%')
                ->join('product_purchases', 'payment_vouchers.module_id', '=', 'product_purchases.id');
        }
        if (is($created_at)) {
            $date =  explode(' to ', $created_at);
            $date_start = trim($date[0] . ' 00:00:00');
            $date_end = trim($date[1] . ' 23:59:59');
            if ($date[0] != $date[1]) {
                $data =  $data->where('payment_vouchers.created_at', '>=', $date_start)->where('payment_vouchers.created_at', '<=', $date_end);
            }
        }
        $data = $data->paginate(env('APP_paginate'));
        return view('cashbook.payment.payment.data', compact('data'))->render();
    }
    public function ajaxDelete(Request $request)
    {
        $id_checked  = $request->id_checked;
        if (empty($id_checked)) {
            return response()->json(array('error' => 'Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này'));
        } else {
            $data = PaymentVouchers::whereIn('id', $id_checked)->get();
            if (!$data->isEmpty()) {
                foreach ($data as $item) {
                    if ($item->group_id == 11) {
                        return response()->json(array('error' => 'Không được hủy các phiếu chi Tự động, Thanh toán cho đơn nhập hàng và trạng thái “Đã hủy”'));
                    }
                    if ($item->module == 'product_purchases') {
                        return response()->json(array('error' => 'Không được hủy các phiếu chi Tự động, Thanh toán cho đơn nhập hàng và trạng thái “Đã hủy”'));
                    }
                    if ($item->status == 'cancelled') {
                        return response()->json(array('error' => 'Không được hủy các phiếu chi Tự động, Thanh toán cho đơn nhập hàng và trạng thái “Đã hủy”'));
                    }
                    PaymentVouchers::where('id', $item->id)->update(['status' => 'cancelled', 'updated_at' => Carbon::now()]);
                }
                return response()->json(array('success' => 'Hủy phiếu chi thành công'));
            } else {
                return response()->json(array('error' => 'Bạn phải chọn ít nhất 1 bản ghi để thực hiện chức năng này'));
            }
        }
    }
    public function loadModule($table = '')
    {
        $data = [];
        $html = '';
        if ($table == 'users') {
            $data = \App\Models\User::select('id', 'name as title', 'phone')->get();
            $html .= '<option value="0">Chọn nhân viên</option>';
        } else if ($table == 'customers') {
            $data = \App\Models\Customer::select('id', 'name as title', 'phone')->get();
            $html .= '<option value="0">Chọn khách hàng</option>';
        } else if ($table == 'suppliers') {
            $data = \App\Models\Suppliers::select('id', 'title')->get();
            $html .= '<option value="0">Chọn nhà cung cấp</option>';
        } else if ($table == 'ships') {
            $data = \App\Models\Ship::select('id', 'title')->where('id', '!=', 3)->get();
            $html .= '<option value="0">Chọn đối tác vận chuyển</option>';
        } else if ($table == 'product_purchases') {
            $data = \App\Models\ProductPurchase::select('id', 'code as title')->where('financialStatus', '!=', 'paid')->get();
            $html .= '<option value="0">Chọn đơn nhập hàng</option>';
        }
        return ['data' => $data, 'html' => $html];
    }
}
