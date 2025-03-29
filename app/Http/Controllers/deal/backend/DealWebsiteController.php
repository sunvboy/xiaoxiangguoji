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

class DealWebsiteController extends Controller
{
    protected $table = 'deals';
    public function __construct()
    {
        $customers = dropdown(Customer::select('id', 'name')->get(), '', 'id', 'name');
        $category_products_child = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 2)->get(), '', 'id', 'title');
        View::share(['module' => $this->table, 'active' => 'website', 'customers' => $customers, 'category_products_child' => $category_products_child]);
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->where('id', '!=', 1)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'website')->orderBy('order', 'asc')->get();
        return view('deal.website.index', compact('data', 'category_products', 'deal_views', 'products'));
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
    public function update(Request $request, $id)
    {
        if (!empty($request->file('file'))) {
            $file = $request->file('file');
            $filename = $request->file('file')->getClientOriginalName();
            $filePath = base_path('upload/files/');
            $file->move($filePath, $filename);
        }
        $phan_loai =  !empty($request->product_phanloai) ? $request->product_phanloai_deal : [];
        $tmp_phan_loai = !empty($phan_loai) ? collect($phan_loai)->unique()->join(',') : null;
        if ($request->catalogue_id == 1) {
            $duy_tri =  $request->product_duytri_deal;
            $tmp_duy_tri = !empty($phan_loai) ? collect($duy_tri)->unique()->toArray() : null;
        } else {
            $duy_tri =  $phan_loai;
            $tmp_duy_tri = $tmp_phan_loai;
        }
        $data = [
            'file' => !empty($filename) ?  'upload/files/' . $filename : null,
            'ips' => !empty($request->ips) ? $request->ips : '',
            'note' => !empty($request->note) ? $request->note : '',
            'brand_id' => !empty($tmp_phan_loai) ? $tmp_phan_loai : null,
            'tag_id' => !empty($duy_tri) ? json_encode($tmp_duy_tri) : null,
            'catalogue_id' => $request->catalogue_id,
            'title' => !empty($request->title) ? $request->title : null,
            'status' => !empty($request->status) ? $request->status : null,
            'website' => !empty($request->website) ? json_encode($request->website) : null,
            'price' => isset($request->price) ? str_replace('.', '', $request->price) : 0,
            'price_collected' => isset($request->price_collected) ? str_replace('.', '', $request->price_collected) : 0,
            'price_not_collected' => isset($request->price_not_collected) ? str_replace('.', '', $request->price_not_collected) : 0,
            'date_end' => Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d'),
            'customer_id' => $request->customer_id,
            'phone' => !empty($request->phone) ? $request->phone : null,
            'email' => !empty($request->email) ? $request->email : null,
            'address' => !empty($request->address) ? $request->address : null,
            'type' => !empty($request->type) ? $request->type : null,
            'source' => !empty($request->source) ? $request->source : null,
            'source_description' => $request->source_description,
            'source_date_start' => Carbon::createFromFormat('d/m/Y', $request->source_date_start)->format('Y-m-d'),
            'source_date_end' =>  Carbon::createFromFormat('d/m/Y', $request->source_date_end)->format('Y-m-d'),
            'users_support' => !empty($request->users_support) ? json_encode($request->users_support) : null,
            'users_join' => !empty($request->users_join) ?  json_encode($request->users_join) : null,
            'free' => !empty($request->free) ? json_encode($request->free) : null,
            'price_1' => !empty($request->price_1) ? $request->price_1 : null,
            'price_2' => !empty($request->price_2) ? $request->price_2 : null,
            'price_3' => !empty($request->price_3) ? $request->price_3 : null,
            'price_4' => !empty($request->price_4) ? $request->price_4 : null,
            'price_5' => !empty($request->price_5) ? $request->price_5 : null,
            'company' => !empty($request->price_6) ? $request->company : null,
            'updated_at' => Carbon::now(),
            'userid_updated' => Auth::user()->id,
        ];
        Deal::where('id', $id)->update($data);
        if (!empty($id)) {
            //xóa deal_relationships
            DealRelationships::where(['deal_id' => $id])->delete();
            $deal_relationships = [];
            $product_title =  $request->product_title;
            $product_price =  $request->product_price;
            $product_quantity =  $request->product_quantity;
            $product_price_sale =  $request->product_price_sale;
            $product_unit =  $request->product_unit;
            $product_price_tax =  $request->product_price_tax;
            $taxInputOfItem =  $request->taxInputOfItem;
            if (!empty($product_title)) {
                foreach ($product_title as $key => $item) {
                    $deal_relationships[] = [
                        'title' => !empty($item) ? $item : '',
                        'deal_id' => $id,
                        'price' => !empty($product_price) ? $product_price[$key] : 0,
                        'total' => $product_price[$key] * $product_quantity[$key],
                        'quantity' => !empty($product_quantity) ? $product_quantity[$key] : 0,
                        'unit' => !empty($product_unit) ? $product_unit[$key] : '',
                        'sales' => !empty($product_price_sale) ? $product_price_sale[$key] : null,
                        'tax' => !empty($product_price_tax) ? $product_price_tax[$key] : 0,
                        'tax_price' => !empty($taxInputOfItem) ? $taxInputOfItem[$key] : 0,
                        'duy_tri' => !empty($duy_tri) ? $duy_tri[$key] : null,
                        'phan_loai' => !empty($phan_loai) ? $phan_loai[$key] : null,
                        'created_at' => Carbon::now(),
                    ];
                }
            }
            DealRelationships::insert($deal_relationships);
        }
        return redirect()->route('deals.website.index')->with('success', "Thêm mới hợp đồng thành công thành công");
    }
    public function month(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('id', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $type = $request->type;
        $date_end = $request->date_end;
        $product = $request->product;
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('website', 'like', '%' . $request->keyword . '%');
        }
        if (!empty($product)) {
            $data =  $data->where('products', 'like', '%' . $product . '%');
        }
        if (!empty($customer_id)) {
            $data =  $data->where('customer_id', $customer_id);
        }
        if (!empty($catalogue_id)) {
            $data =  $data->where('catalogue_id', $catalogue_id);
        }
        if (!empty($status)) {
            $data =  $data->where('status', $status);
        }
        if (!empty($type)) {
            $data =  $data->where('type', $type);
        }
        $source_date_start = $request->source_date_start;
        $source_date_end = $request->source_date_end;
        if (!empty($source_date_start)) {
            $sourceDateStart = explode("/", $source_date_start);
            $data = $data->whereMonth('source_date_start', $sourceDateStart[1])
                ->whereYear('source_date_start', $sourceDateStart[2]);
        }
        $source_date_end = $request->source_date_end;
        if (!empty($source_date_end)) {
            $sourceDateEnd = explode("/", $source_date_end);
            $data = $data->whereMonth('source_date_start', $sourceDateEnd[1])
                ->whereYear('source_date_start', $sourceDateEnd[2]);
        }

        if (!empty($date_end)) {
            $dateEnd = explode("/", $date_end);
            $data = $data->whereMonth('date_end', $dateEnd[1])
                ->whereYear('date_end', $dateEnd[2]);
        }
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        if (is($request->catalogue_id)) {
            $data->appends(['catalogue_id' => $request->catalogue_id]);
        }
        if (is($request->customer_id)) {
            $data->appends(['customer_id' => $request->customer_id]);
        }
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->type)) {
            $data->appends(['type' => $request->type]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->source_date_start)) {
            $data->appends(['source_date_start' => $request->source_date_start]);
        }
        if (is($request->source_date_end)) {
            $data->appends(['source_date_end' => $request->source_date_end]);
        }
        if (is($request->product)) {
            $data->appends(['product' => $request->product]);
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->where('id', '!=', 1)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'website')->orderBy('order', 'asc')->get();
        return view('deal.website.month', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function experience(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->whereNotIn('status',  [5, 8])->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->where('id', '!=', 1)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'website')->orderBy('order', 'asc')->get();
        return view('deal.website.experience', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function wait(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->where('type', null)->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->where('id', '!=', 1)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'website')->orderBy('order', 'asc')->get();
        return view('deal.website.wait', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function status(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->whereIn('status',  [5, 8])->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->where('id', '!=', 1)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'website')->orderBy('order', 'asc')->get();
        return view('deal.website.status', compact('data', 'category_products', 'deal_views', 'products'));
    }
}
