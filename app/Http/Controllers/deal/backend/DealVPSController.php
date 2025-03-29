<?php

namespace App\Http\Controllers\deal\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealHistory;
use App\Models\DealRelationships;
use App\Models\DealView;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DealVPSController extends Controller
{
    protected $table = 'deals';
    public function __construct()
    {
        $customers = dropdown(Customer::select('id', 'name')->get(), '', 'id', 'name');
        $category_products_child = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 2)->get(), '', 'id', 'title');
        View::share(['module' => $this->table, 'active' => 'vps', 'customers' => $customers, 'category_products_child' => $category_products_child]);
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null])->where('catalogue_id', 21199)->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'vps')->orderBy('order', 'asc')->get();
        return view('deal.index.index', compact('data', 'category_products', 'deal_views', 'products'));
    }

    public function create()
    {
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $customers = dropdown(Customer::select('id', 'name')->get(), 'Chọn khách hàng', 'id', 'name');
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        $companies = array(
            'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT' => 'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT',
            'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT' => 'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT'
        );
        $action = 'create';
        $products = Product::select('id', 'title', 'price')->get();
        return view('deal.backend.create', compact('customers', 'users', 'companies', 'action', 'products', 'category_products'));
    }

    public function edit($id)
    {
        $detail = Deal::where('deleted_at', null)->with(['deal_relationships', 'category_products'])->with(['deal_invoices' => function ($q) {
            $q->where('deleted_at', null)->orderBy('id', 'desc');
        }])->find($id);
        if (!isset($detail)) {
            return redirect()->route('deals.index')->with('error', "Thảo thuận không tồn tại");
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $customers = dropdown(Customer::select('id', 'name')->get(), 'Chọn khách hàng', 'id', 'name');
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        $companies = array(
            'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT' => 'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT',
            'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT' => 'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT'
        );
        $action = 'update';
        $products = Product::select('id', 'title', 'price')->get();
        $history = $detail->deal_histories;
        return view('deal.backend.create', compact('detail', 'customers', 'users', 'companies', 'action', 'products', 'category_products', 'history'));
    }
    public function copy($id)
    {
        $detail = Deal::where('deleted_at', null)->with(['deal_relationships', 'category_products', 'deal_invoices'])->find($id);
        if (!isset($detail)) {
            return redirect()->route('deals.index')->with('error', "Thảo thuận không tồn tại");
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $customers = dropdown(Customer::select('id', 'name')->get(), 'Chọn khách hàng', 'id', 'name');
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        $companies = array(
            'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT' => 'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT',
            'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT' => 'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT'
        );
        $action = 'create';
        $products = Product::select('id', 'title', 'price')->get();
        $history = DealHistory::orderBy('id', 'desc')->get();
        return view('deal.backend.create', compact('detail', 'customers', 'users', 'companies', 'action', 'products', 'category_products', 'history'));
    }

    //1. HĐ Đang sử dụng 
    public function using(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'type' => 1])->where('catalogue_id', 21199)->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'vps')->orderBy('order', 'asc')->get();
        return view('deal.vps.using', compact('data', 'category_products', 'deal_views', 'products'));
    }
    //2. HĐ sắp hết hạn ( liệt kê trước 1 tháng)
    public function is(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'catalogue_id' => 21199])
            ->where('source_date_end', '>', Carbon::today())
            ->where('source_date_end', '<', Carbon::now()->addMonth()->endOfMonth())
            ->with(['user_created', 'user_updated', 'deal_relationships'])
            ->orderBy('source_date_end', 'asc')
            ->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'vps')->orderBy('order', 'asc')->get();
        return view('deal.vps.is', compact('data', 'category_products', 'deal_views', 'products'));
    }
    //2. HĐ đã hết hạn 
    public function expired(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'catalogue_id' => 21199, 'type' => 0])
            ->with(['user_created', 'user_updated', 'deal_relationships'])
            ->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'vps')->orderBy('order', 'asc')->get();
        return view('deal.vps.expired', compact('data', 'category_products', 'deal_views', 'products'));
    }
}
