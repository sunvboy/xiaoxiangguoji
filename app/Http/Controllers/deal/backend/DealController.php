<?php

namespace App\Http\Controllers\deal\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealBrandTmp;
use App\Models\DealHistory;
use App\Models\DealInvoice;
use App\Models\DealRelationships;
use App\Models\DealView;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use DateTime;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class DealController extends Controller
{
    protected $table = 'deals';
    public function __construct()
    {
        $category_products_child = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 2)->get(), '', 'id', 'title');
        View::share(['module' => $this->table, 'active' => 'maintain', 'category_products_child' => $category_products_child]);
    }
    public function index(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null,  'catalogue_id' => 1])->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        return view('deal.index.index', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function search(Request $request)
    {
        $id = $request->id;
        $customer = Customer::find($id);
        $module = $this->table;
        $data1 = Deal::where('deleted_at', null)->where('customer_id', $id)->where('catalogue_id', 1)->orderBy('type', 'desc')->orderBy('source_date_end', 'asc')->orderBy('id', 'desc')->paginate(env('APP_paginate'));
        $data2 = Deal::where('deleted_at', null)->where('customer_id', $id)->whereNotIn('catalogue_id', [1, 21199])->orderBy('type', 'desc')->orderBy('source_date_end', 'asc')->orderBy('id', 'desc')->paginate(env('APP_paginate'));
        $data3 = Deal::where('deleted_at', null)->where('customer_id', $id)->where('catalogue_id', 21199)->orderBy('type', 'desc')->orderBy('source_date_end', 'asc')->orderBy('id', 'desc')->paginate(env('APP_paginate'));
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        $deal_views_website = DealView::where('type', 'website')->orderBy('order', 'asc')->get();
        $deal_views_vps = DealView::where('type', 'vps')->orderBy('order', 'asc')->get();
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        return view('deal.company.index', compact('data1', 'data2', 'data3', 'customer', 'deal_views', 'category_products', 'products', 'deal_views_website', 'deal_views_vps'));
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
    public function store(Request $request)
    {
        if (!empty($request->file('file'))) {
            $file = $request->file('file');
            $filename = $request->file('file')->getClientOriginalName();
            $filePath = base_path('upload/files/');
            $file->move($filePath, $filename);
        }
        $phan_loai =  !empty($request->product_phanloai) ? $request->product_phanloai : [];
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
            // 'catalogue_child_id' => !empty($request->catalogue_child_id) ? collect($request->catalogue_child_id)->join(',') : null,
            'brand_id' => !empty($tmp_phan_loai) ? collect($tmp_phan_loai)->join(',') : null,
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
            'type' => $request->type,
            'source' => !empty($request->source) ? $request->source : null,
            'source_description' => $request->source_description,
            'source_date_start' => Carbon::createFromFormat('d/m/Y', $request->source_date_start)->format('Y-m-d'),
            'source_date_end' =>  Carbon::createFromFormat('d/m/Y', $request->source_date_end)->format('Y-m-d'),
            'users_support' => !empty($request->users_support) ? json_encode($request->users_support) : null,
            'users_join' => !empty($request->users_join) ?  json_encode($request->users_join) : null,
            'free' => !empty($request->free) ? json_encode($request->free) : null,
            'suspend' => !empty($request->suspend) ? $request->suspend : null,
            'price_1' => !empty($request->price_1) ? $request->price_1 : null,
            'price_2' => !empty($request->price_2) ? $request->price_2 : null,
            'price_3' => !empty($request->price_3) ? $request->price_3 : null,
            'price_4' => !empty($request->price_4) ? $request->price_4 : null,
            'price_5' => !empty($request->price_5) ? $request->price_5 : null,
            'company' => !empty($request->price_6) ? $request->company : null,
            'created_at' => Carbon::now(),
            'userid_created' => Auth::user()->id,
        ];
        $id = Deal::insertGetId($data);
        if (!empty($id)) {
            $deal_relationships = [];
            $product_title =  $request->product_title;
            $product_price =  $request->product_price;
            $product_quantity =  $request->product_quantity;
            $product_price_sale =  $request->product_price_sale;
            $product_unit =  $request->product_unit;
            $product_price_tax =  $request->product_price_tax;
            $product_domain =  $request->product_domain;
            if (!empty($product_title)) {
                foreach ($product_title as $key => $item) {
                    $deal_relationships[] = [
                        'title' => !empty($item) ? $item : '',
                        'deal_id' => $id,
                        'price' => !empty($product_price) ? $product_price[$key] : 0,
                        'total' => $product_price[$key] * $product_quantity[$key],
                        'quantity' => !empty($product_quantity) ? $product_quantity[$key] : 0,
                        'unit' => !empty($product_unit) ? $product_unit[$key] : '',
                        'sales' => !empty($product_price_sale) ? $product_price_sale[$key] : 0,
                        'tax' => !empty($product_price_tax) ? $product_price_tax[$key] : 0,
                        'tax_price' => !empty($taxInputOfItem) ? $taxInputOfItem[$key] : 0,
                        'duy_tri' => !empty($duy_tri) ? $duy_tri[$key] : null,
                        'phan_loai' => !empty($phan_loai) ? $phan_loai[$key] : null,
                        'domain' => !empty($product_domain) ? $product_domain[$key] : null,
                        'created_at' => Carbon::now(),
                    ];
                }
            }
            DealRelationships::insert($deal_relationships);
            //ghi lịch sử
            DealHistory::insertGetId([
                'created_at' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'deal_id' => $id,
                'note' => 'Tạo Hợp đồng thành công'
            ]);
        }
        if ($request->catalogue_id == 1) {
            return redirect()->route('deals.edit', ['id' => $id])->with('success', "Thêm mới hợp đồng thành công");
        } else if ($request->catalogue_id  == 21199) {
            return redirect()->route('deals.vps.edit', ['id' => $id])->with('success', "Thêm mới hợp đồng thành công");
        } else {
            return redirect()->route('deals.website.edit', ['id' => $id])->with('success', "Thêm mới hợp đồng thành công");
        }
    }
    public function edit($id)
    {
        $detail = Deal::where('deleted_at', null)->with(['deal_relationships', 'category_products'])->with(['deal_invoices' => function ($q) {
            $q->where('deleted_at', null)->orderBy('id', 'desc');
        }])->find($id);
        if (!isset($detail)) {
            return redirect()->route('deals.index')->with('error', "Hợp đồng không tồn tại");
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
    public function email($id)
    {
        $detail = Deal::where('deleted_at', null)->with(['deal_relationships', 'category_products'])->with(['deal_invoices' => function ($q) {
            $q->where('deleted_at', null)->orderBy('id', 'desc');
        }])->find($id);
        if (!isset($detail)) {
            return redirect()->route('deals.index')->with('error', "Hợp đồng không tồn tại");
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
        return view('deal.backend.email', compact('detail', 'customers', 'users', 'companies', 'action', 'products', 'category_products', 'history'));
    }
    public function emailStore($id, Request $request)
    {
        //gui email
        $sendMail = array(
            'subject' => 'Thông báo sắp hết hạn dịch vụ',
            'id' => $id,
            'request' => $request,
        );
        if (!empty($request->email_cc)) {
            Mail::to($request->email)->cc(explode(",", $request->email_cc))->send(new \App\Mail\SendMailDeal($sendMail));
        } else {
            Mail::to($request->email)->cc($request->email_cc)->send(new \App\Mail\SendMailDeal($sendMail));
        }
        DealHistory::insertGetId([
            'created_at' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'deal_id' => $id,
            'note' => "Gửi Email gia hạn thành công"
        ]);
        return redirect()->route('deals.email', ['id' => $id])->with('success', "Gửi email thành công");
    }
    public function copy($id)
    {
        $detail = Deal::where('deleted_at', null)->with(['deal_relationships', 'category_products', 'deal_invoices'])->find($id);
        if (!isset($detail)) {
            return redirect()->route('deals.index')->with('error', "Hợp đồng không tồn tại");
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
        $phan_loai =  !empty($request->product_phanloai) ? $request->product_phanloai : [];
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
            // 'catalogue_child_id' => !empty($request->catalogue_child_id) ? collect($request->catalogue_child_id)->join(',') : null,
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
            'type' => $request->type,
            'source' => !empty($request->source) ? $request->source : null,
            'source_description' => $request->source_description,
            'source_date_start' => Carbon::createFromFormat('d/m/Y', $request->source_date_start)->format('Y-m-d'),
            'source_date_end' =>  Carbon::createFromFormat('d/m/Y', $request->source_date_end)->format('Y-m-d'),
            'users_support' => !empty($request->users_support) ? json_encode($request->users_support) : null,
            'users_join' => !empty($request->users_join) ?  json_encode($request->users_join) : null,
            'free' => !empty($request->free) ? json_encode($request->free) : null,
            'suspend' => !empty($request->suspend) ? $request->suspend : null,
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
            $product_domain =  $request->product_domain;
            if (!empty($product_title)) {
                foreach ($product_title as $key => $item) {
                    $deal_relationships[] = [
                        'title' => !empty($item) ? $item : '',
                        'deal_id' => $id,
                        'price' => !empty($product_price) ? $product_price[$key] : 0,
                        'quantity' => !empty($product_quantity) ? $product_quantity[$key] : 0,
                        'unit' => !empty($product_unit) ? $product_unit[$key] : '',
                        'sales' => !empty($product_price_sale) ? $product_price_sale[$key] : 0,
                        'tax' => !empty($product_price_tax) ? $product_price_tax[$key] : 0,
                        'tax_price' => !empty($taxInputOfItem) ? $taxInputOfItem[$key] : 0,
                        'total' => $product_price[$key] * $product_quantity[$key],
                        'phan_loai' => !empty($phan_loai) ? $phan_loai[$key] : null,
                        'duy_tri' => !empty($duy_tri) ? $duy_tri[$key] : null,
                        'domain' => !empty($product_domain) ? $product_domain[$key] : null,
                        'created_at' => Carbon::now(),
                    ];
                }
            }
            DealRelationships::insert($deal_relationships);
        }
        if ($request->catalogue_id == 1) {
            return redirect()->route('deals.edit', ['id' => $id])->with('success', "Cập nhập hợp đồng thành công");
        } else if ($request->catalogue_id  == 21199) {
            return redirect()->route('deals.vps.edit', ['id' => $id])->with('success', "Cập nhập hợp đồng thành công");
        } else {
            return redirect()->route('deals.website.edit', ['id' => $id])->with('success', "Cập nhập hợp đồng thành công");
        }
    }
}
