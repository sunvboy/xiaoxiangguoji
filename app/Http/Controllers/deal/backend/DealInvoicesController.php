<?php

namespace App\Http\Controllers\deal\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Deal;
use App\Models\DealInvoice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DealInvoicesExport;
use App\Models\DealHistory;
use App\Models\DealInvoiceRelationships;
use App\Models\DealInvoiceTmp;
use App\Models\DealRelationships;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DealInvoicesController extends Controller
{
    protected $table = 'deal_invoices';
    public function __construct()
    {
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        View::share(['module' => $this->table, 'users' => $users]);
    }

    public function index(Request $request)
    {
        // $data =  DealInvoiceTmp::get();
        // foreach ($data as $item) {
        //     DealInvoice::where('id', $item->deal_invoice_id)->update([
        //         'price' => $item->price,
        //         'price_tax' => $item->price_tax,
        //         'total' => $item->total,
        //     ]);
        // };
        // die;
        // $data = DealInvoice::where(['deleted_at' => null])->with(['deal'])->orderBy('id', 'desc')->get();
        // foreach ($data as $item) {
        //     if (!empty($item->date_end)) {
        //         $deal = Deal::where('title', $item->title)->whereYear('date_end', \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->date_end)->format('Y'))->first();
        //         if (!empty($deal)) {
        //             DealInvoice::where('id', $item->id)->update(['deal_id' => $deal->id]);
        //         }
        //     }
        // }
        // dd($data);
        $data = DealInvoice::where(['deleted_at' => null])->with(['deal'])->orderBy('id', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc

        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')->orWhere('id', 'like', '%' . $request->keyword . '%')->orWhere('comment', 'like', '%' . $request->keyword . '%');
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
        if (!empty($source_date_end)) {
            $data = $data->where('source_date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $source_date_end)->format('Y-m-d 00:00:00'));
        }
        if (!empty($date_end)) {
            $data = $data->where('date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d 00:00:00'));
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
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->source_date_start)) {
            $data->appends(['source_date_start' => $request->source_date_start]);
        }
        if (is($request->product)) {
            $data->appends(['product' => $request->product]);
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        return view('deal.invoices.index', compact('data', 'category_products'));
    }
    public function create(Request $request)
    {
        $deals = [];
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        $action = 'create';
        $deal_id = old('deal_id');
        if (!empty($deal_id)) {
            $deals = dropdown(Deal::select('id', 'title')->where('id', $deal_id)->get(), '', 'id', 'title');
        }
        return view('deal.invoices.create', compact('action', 'deals', 'category_products', 'users'));
    }
    public function store(Request $request)
    {
        $tax = 0;
        if (!empty($request->status_tax)) {
            $tax = isset($request->price) ? ((int)str_replace('.', '', $request->price) / 100) * (int)$request->status_tax : 0;
        }
        $request->validate([
            'title' => 'required',
            'catalogue_id' => 'required',
            'deal_id' => 'required',
            'user_id' => 'required',
        ]);
        $deal = Deal::select('source_date_end', 'catalogue_id')->find($request->deal_id);
        $invoices_title = $request->invoices_title;
        $invoices_phan_loai = $request->invoices_phan_loai;
        $invoices_duy_tri = $request->invoices_duy_tri;
        $invoices_price = $request->invoices_price;
        $invoices_quantity = $request->invoices_quantity;
        $invoices_tax = $request->invoices_tax;
        $invoices_tax_price = $request->invoices_tax_price;
        $invoices_price_total = $request->invoices_price_total;
        $data = [
            'catalogue_id' => !empty($request->catalogue_id) ? $request->catalogue_id : null,
            'deal_id' => !empty($request->deal_id) ? $request->deal_id : null,
            'title' => !empty($request->title) ? $request->title : null,
            'comment' => !empty($request->comment) ? $request->comment : null,
            'note' => !empty($request->note) ? $request->note : null,
            'status' => !empty($request->status) ? $request->status : 0,
            'price' => !empty($request->invoices_price_1) ? $request->invoices_price_1 : 0,
            'price_tax' => !empty($request->invoices_price_2) ? $request->invoices_price_2 : 0,
            'total' => !empty($request->invoices_price_3) ? $request->invoices_price_3 : 0,
            'date_end' => Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d'),
            'source_date_end' => !empty($deal->source_date_end) ? $deal->source_date_end : null,
            'user_id' => !empty($request->user_id) ? $request->user_id : null,
            'created_at' => Carbon::now(),
            'status_tax' => !empty($request->status_tax) ? $request->status_tax : null,
        ];
        $create = DealInvoice::create($data);
        if (!empty($create)) {
            if (!empty($invoices_title)) {
                foreach ($invoices_title as $key => $item) {
                    $duy_tri_create = !empty($deal->catalogue_id == 1) ? (!empty($invoices_duy_tri) ? $invoices_duy_tri[$key] : '') : (!empty($invoices_phan_loai) ? $invoices_phan_loai[$key] : '');
                    $deal_invoice_relationships[] = [
                        'title' => !empty($item) ? $item : '',
                        'deal_invoice_id' => $create->id,
                        'user_id' => !empty($request->user_id) ? $request->user_id : 0,
                        'phan_loai' => !empty($invoices_phan_loai) ? $invoices_phan_loai[$key] : 0,
                        'duy_tri' => $duy_tri_create,
                        'price' => !empty($invoices_price) ? $invoices_price[$key] : 0,
                        'quantity' => !empty($invoices_quantity) ? $invoices_quantity[$key] : 0,
                        'tax' => !empty($invoices_tax) ? $invoices_tax[$key] : 0,
                        'tax_price' => !empty($invoices_tax_price) ? str_replace('.', '', $invoices_tax_price[$key]) : 0,
                        'total' => !empty($invoices_price_total) ? $invoices_price_total[$key] : 0,
                        'created_at' => Carbon::now(),
                    ];
                }
                DealInvoiceRelationships::insert($deal_invoice_relationships);
            }
            $DealHistory = "Tạo mới hóa đơn <span class='text-primary'>#$create->id</span>";
            DealHistory::insertGetId([
                'created_at' => Carbon::now(),
                'user_id' => Auth::user()->id,
                'deal_id' => $request->deal_id,
                'note' => $DealHistory
            ]);
            return redirect()->route('deals.invoices')->with('success', "Thêm mới hóa đơn thành công");
        }
    }
    public function edit($id)
    {
        $detail = DealInvoice::where('deleted_at', null)->find($id);
        if (!isset($detail)) {
            return redirect()->route('deals.invoices')->with('error', "Hóa đơn không tồn tại");
        }
        $deals = [];
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        $action = 'update';
        $deal_id = !empty(old('deal_id')) ? old('deal_id') : $detail->deal->id;
        if (!empty($deal_id)) {
            $deals = dropdown(Deal::select('id', 'title')->where('id', $deal_id)->get(), '', 'id', 'title');
        }
        return view('deal.invoices.create', compact('detail', 'action', 'deals', 'category_products', 'users'));
    }
    public function update(Request $request, $id)
    {
        $tax = 0;
        if (!empty($request->status_tax)) {
            $tax = isset($request->price) ? ((int)str_replace('.', '', $request->price) / 100) * (int)$request->status_tax : 0;
        }
        $request->validate([
            'title' => 'required',
            'catalogue_id' => 'required',
            'deal_id' => 'required',
            'user_id' => 'required',
        ]);

        $deal = Deal::select('source_date_end', 'catalogue_id')->find($request->deal_id);
        $invoices_title = $request->invoices_title;
        $invoices_phan_loai = $request->invoices_phan_loai;
        $invoices_duy_tri = $request->invoices_duy_tri;
        $invoices_price = $request->invoices_price;
        $invoices_quantity = $request->invoices_quantity;
        $invoices_tax = $request->invoices_tax;
        $invoices_tax_price = $request->invoices_tax_price;
        $invoices_price_total = $request->invoices_price_total;
        $data = [
            'catalogue_id' => !empty($request->catalogue_id) ? $request->catalogue_id : null,
            'deal_id' => !empty($request->deal_id) ? $request->deal_id : null,
            'title' => !empty($request->title) ? $request->title : null,
            'comment' => !empty($request->comment) ? $request->comment : null,
            'note' => !empty($request->note) ? $request->note : null,
            'status' => !empty($request->status) ? $request->status : 0,
            'price' => !empty($request->invoices_price_1) ? $request->invoices_price_1 : 0,
            'price_tax' => !empty($request->invoices_price_2) ? $request->invoices_price_2 : 0,
            'total' => !empty($request->invoices_price_3) ? $request->invoices_price_3 : 0,
            'date_end' => Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d'),
            'source_date_end' => !empty($deal->source_date_end) ? $deal->source_date_end : null,
            'updated_at' => Carbon::now(),
            'status_tax' => !empty($request->status_tax) ? $request->status_tax : null,
        ];
        DealInvoice::where('id', $id)->update($data);
        DealInvoiceRelationships::where(['deal_invoice_id' => $id])->delete();
        if (!empty($invoices_title)) {
            foreach ($invoices_title as $key => $item) {
                $duy_tri_create = !empty($deal->catalogue_id == 1) ? (!empty($invoices_duy_tri) ? $invoices_duy_tri[$key] : '') : (!empty($invoices_phan_loai) ? $invoices_phan_loai[$key] : '');
                $deal_invoice_relationships[] = [
                    'title' => !empty($item) ? $item : '',
                    'deal_invoice_id' => $id,
                    'user_id' => !empty($request->user_id) ? $request->user_id : 0,
                    'phan_loai' => !empty($invoices_phan_loai) ? $invoices_phan_loai[$key] : 0,
                    'duy_tri' => $duy_tri_create,
                    'price' => !empty($invoices_price) ? $invoices_price[$key] : 0,
                    'quantity' => !empty($invoices_quantity) ? $invoices_quantity[$key] : 0,
                    'tax' => !empty($invoices_tax) ? $invoices_tax[$key] : 0,
                    'tax_price' => !empty($invoices_tax_price) ? str_replace('.', '', $invoices_tax_price[$key]) : 0,
                    'total' => !empty($invoices_price_total) ? $invoices_price_total[$key] : 0,
                    'created_at' => Carbon::now(),
                ];
            }
            DealInvoiceRelationships::insert($deal_invoice_relationships);
        }
        $DealHistory = "Cập nhập hóa đơn <span class='text-primary'>#$id</span>";
        DealHistory::insertGetId([
            'created_at' => Carbon::now(),
            'user_id' => Auth::user()->id,
            'deal_id' => $request->deal_id,
            'note' => $DealHistory
        ]);
        return redirect()->route('deals.invoices')->with('success', "Cập nhập hóa đơn thành công");
    }
    //get deal
    public function showDeal(Request $request)
    {
        $action = $request->action;

        $detail = Deal::with('deal_relationships')->find($request->deal_id);
        return response()->json(
            array(
                'html' => view('deal.invoices.product', compact('detail', 'action'))->render(),
            )
        );
    }
    //end
    public function newly(Request $request)
    {
        $module = $this->table;
        $data = DealInvoice::where(['deleted_at' => null])->whereDate('created_at', now()->toDateString())->with(['deal'])->orderBy('id', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc

        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')->orWhere('id', 'like', '%' . $request->keyword . '%')->orWhere('comment', 'like', '%' . $request->keyword . '%');
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
        if (!empty($source_date_end)) {
            $data = $data->where('source_date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $sourceDateEnd)->format('Y-m-d 00:00:00'));
        }
        if (!empty($date_end)) {
            $data = $data->where('date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d 00:00:00'));
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
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->source_date_start)) {
            $data->appends(['source_date_start' => $request->source_date_start]);
        }
        if (is($request->product)) {
            $data->appends(['product' => $request->product]);
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        return view('deal.invoices.index', compact('data', 'category_products'));
    }
    public function waiting(Request $request)
    {
        $module = $this->table;
        $data = DealInvoice::where(['deleted_at' => null, 'status' => 0])->with(['deal'])->orderBy('id', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc

        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')->orWhere('id', 'like', '%' . $request->keyword . '%')->orWhere('comment', 'like', '%' . $request->keyword . '%');
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
        if (!empty($source_date_end)) {
            $data = $data->where('source_date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $sourceDateEnd)->format('Y-m-d 00:00:00'));
        }
        if (!empty($date_end)) {
            $data = $data->where('date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d 00:00:00'));
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
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->source_date_start)) {
            $data->appends(['source_date_start' => $request->source_date_start]);
        }
        if (is($request->product)) {
            $data->appends(['product' => $request->product]);
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        return view('deal.invoices.index', compact('data', 'category_products'));
    }
    public function abort(Request $request)
    {
        $module = $this->table;
        $data = DealInvoice::where(['deleted_at' => null, 'status_2' => 1])->with(['deal'])->orderBy('id', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')->orWhere('id', 'like', '%' . $request->keyword . '%')->orWhere('comment', 'like', '%' . $request->keyword . '%');
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
        if (!empty($source_date_end)) {
            $data = $data->where('source_date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $sourceDateEnd)->format('Y-m-d 00:00:00'));
        }
        if (!empty($date_end)) {
            $data = $data->where('date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d 00:00:00'));
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
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->source_date_start)) {
            $data->appends(['source_date_start' => $request->source_date_start]);
        }
        if (is($request->product)) {
            $data->appends(['product' => $request->product]);
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        return view('deal.invoices.index', compact('data', 'category_products'));
    }
    public function web(Request $request)
    {
        $module = $this->table;
        $data = DealInvoice::where(['deleted_at' => null, 'catalogue_id' => 2])->with(['deal'])->orderBy('id', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')->orWhere('id', 'like', '%' . $request->keyword . '%')->orWhere('comment', 'like', '%' . $request->keyword . '%');
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
        if (!empty($source_date_end)) {
            $data = $data->where('source_date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $sourceDateEnd)->format('Y-m-d 00:00:00'));
        }
        if (!empty($date_end)) {
            $data = $data->where('date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d 00:00:00'));
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
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->source_date_start)) {
            $data->appends(['source_date_start' => $request->source_date_start]);
        }
        if (is($request->product)) {
            $data->appends(['product' => $request->product]);
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        return view('deal.invoices.index', compact('data', 'category_products'));
    }
    public function extend(Request $request)
    {
        $module = $this->table;
        $data = DealInvoice::where(['deleted_at' => null, 'catalogue_id' => 1])->with(['deal'])->orderBy('id', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc

        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')->orWhere('id', 'like', '%' . $request->keyword . '%')->orWhere('comment', 'like', '%' . $request->keyword . '%');
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
        if (!empty($source_date_end)) {
            $data = $data->where('source_date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $sourceDateEnd)->format('Y-m-d 00:00:00'));
        }
        if (!empty($date_end)) {
            $data = $data->where('date_end', \Carbon\Carbon::createFromFormat('d/m/Y', $date_end)->format('Y-m-d 00:00:00'));
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
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->source_date_start)) {
            $data->appends(['source_date_start' => $request->source_date_start]);
        }
        if (is($request->product)) {
            $data->appends(['product' => $request->product]);
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        return view('deal.invoices.index', compact('data', 'category_products'));
    }
    public function deal(Request $request)
    {
        $data = Deal::select('id', 'title', 'website', 'email', 'phone')->where(['deleted_at' => null])->orderBy('id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('id', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('website', 'like', '%' . $request->keyword . '%');
        }
        $data = $data->paginate(env('APP_paginate'));
        return response()->json($data);
    }
    public function export(Request $request)
    {
        $random = rand(100000, 999999);
        $fileName = 'danh_sach_hoa_don' . $random . '.xlsx';
        Excel::store(new DealInvoicesExport($request->date_start, $request->date_end, $request->user_id, $request->status), $fileName, 'public');
        $filepath = Storage::url($fileName);
        return response()->json(['file' => url('') . '/storage/app/public/' . $fileName, 'path' => $filepath]);
    }
    public function statistics(Request $request)
    {
        $roles = Role::where('id', 10)->get()->pluck('id');
        $users = DB::table('role_user')->whereIn('role_id', $roles)->get()->pluck('user_id');
        $module = 'statistics';
        $data = DealInvoice::where(['deleted_at' => null, 'status' => 1, 'status_2' => 0])->whereIn('user_id', $users)->with(['deal'])->orderBy('date_end', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        $date_start =  !empty($request->date_start) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d') : '';
        $date_end = !empty($request->date_end) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : '';
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%');
        }
        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('date_end', '>=', $date_end . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
            }
        }
        if (!empty($request->user_id)) {
            $data = $data->where('user_id', $request->user_id);
        }
        if (!empty($request->status)) {
            $data = $data->where('status', $request->status);
        }
        $sumPrice = $data->get();
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->user_id)) {
            $data->appends(['user_id' => $request->user_id]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }
        return view('deal.invoices.statistics', compact('data', 'module', 'sumPrice'));
    }
    public function statisticsMonth(Request $request)
    {

        $countWebsiteMonth = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->count();
        $roles = Role::where('id', 10)->get()->pluck('id');
        $users = DB::table('role_user')->whereIn('role_id', $roles)->get()->pluck('user_id');
        $module = 'statistics';
        $data = DealInvoice::where(['deleted_at' => null, 'status' => 1, 'status_2' => 0])
            ->whereMonth('date_end', now()->month)
            ->whereYear('date_end', now()->year)
            ->whereIn('user_id', $users)
            ->with(['deal'])
            ->orderBy('date_end', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        $date_start =  !empty($request->date_start) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d') : '';
        $date_end = !empty($request->date_end) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : '';
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%');
        }
        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('date_end', '>=', $date_end . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
            }
        }
        if (!empty($request->user_id)) {
            $data = $data->where('user_id', $request->user_id);
        }
        if (!empty($request->status)) {
            $data = $data->where('status', $request->status);
        }
        $sumPrice = $data->get();
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->user_id)) {
            $data->appends(['user_id' => $request->user_id]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }
        return view('deal.invoices.statistics', compact('data', 'module', 'sumPrice'));
    }
    public function statisticsBefore(Request $request)
    {
        $previousMonthYear = Carbon::now()->subMonths(1);
        $previousMonth = $previousMonthYear->month;
        $previousYear = $previousMonthYear->year;
        $roles = Role::where('id', 10)->get()->pluck('id');
        $users = DB::table('role_user')->whereIn('role_id', $roles)->get()->pluck('user_id');
        $module = 'statistics';
        $data = DealInvoice::where(['deleted_at' => null, 'status' => 1, 'status_2' => 0])
            ->whereMonth('date_end', $previousMonth)
            ->whereYear('date_end', $previousYear)
            ->whereIn('user_id', $users)
            ->with(['deal'])
            ->orderBy('date_end', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        $date_start =  !empty($request->date_start) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d') : '';
        $date_end = !empty($request->date_end) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : '';
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%');
        }
        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('date_end', '>=', $date_end . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
            }
        }
        if (!empty($request->user_id)) {
            $data = $data->where('user_id', $request->user_id);
        }
        if (!empty($request->status)) {
            $data = $data->where('status', $request->status);
        }
        $sumPrice = $data->get();
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->user_id)) {
            $data->appends(['user_id' => $request->user_id]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }
        return view('deal.invoices.statistics', compact('data', 'module', 'sumPrice'));
    }

    //Doanh số gia hạn
    public function limit(Request $request)
    {
        $roles = Role::where('id', 10)->get()->pluck('id');
        $users = DB::table('role_user')->whereNotIn('role_id', $roles)->get()->pluck('user_id');
        $module = 'limit';
        $data = DealInvoice::where(['deleted_at' => null, 'status' => 1, 'status_2' => 0])->whereIn('user_id', $users)->with(['deal'])->orderBy('date_end', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        $date_start =  !empty($request->date_start) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d') : '';
        $date_end = !empty($request->date_end) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : '';
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%');
        }
        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('date_end', '>=', $date_end . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
            }
        }
        if (!empty($request->user_id)) {
            $data = $data->where('user_id', $request->user_id);
        }
        if (!empty($request->status)) {
            $data = $data->where('status', $request->status);
        }
        $sumPrice = $data->get();
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->user_id)) {
            $data->appends(['user_id' => $request->user_id]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }
        $usersEmpty =  DealInvoice::where(['deleted_at' => null])->with('user')->whereIn('user_id', $users)->groupBy('user_id')->get();
        return view('deal.invoices.statistics', compact('data', 'module', 'usersEmpty', 'sumPrice'));
    }
    public function limitMonth(Request $request)
    {

        $countWebsiteMonth = Deal::where(['deleted_at' => null])->whereNotIn('catalogue_id', [1, 21199])->count();
        $roles = Role::where('id', 10)->get()->pluck('id');
        $users = DB::table('role_user')->whereNotIn('role_id', $roles)->get()->pluck('user_id');
        $module = 'limit';
        $data = DealInvoice::where(['deleted_at' => null, 'status' => 1, 'status_2' => 0])
            ->whereMonth('date_end', now()->month)
            ->whereYear('date_end', now()->year)
            ->whereIn('user_id', $users)
            ->with(['deal_invoice_relationships', 'deal'])
            ->orderBy('date_end', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        $date_start =  !empty($request->date_start) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d') : '';
        $date_end = !empty($request->date_end) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : '';
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%');
        }
        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('date_end', '>=', $date_end . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
            }
        }
        if (!empty($request->user_id)) {
            $data = $data->where('user_id', $request->user_id);
        }
        if (!empty($request->status)) {
            $data = $data->where('status', $request->status);
        }
        $sumPrice = $data->get();
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->user_id)) {
            $data->appends(['user_id' => $request->user_id]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }

        return view('deal.invoices.statistics', compact('data', 'module', 'sumPrice'));
    }
    public function limitBefore(Request $request)
    {
        $previousMonthYear = Carbon::now()->subMonths(1);
        $previousMonth = $previousMonthYear->month;
        $previousYear = $previousMonthYear->year;
        $roles = Role::where('id', 10)->get()->pluck('id');
        $users = DB::table('role_user')->whereNotIn('role_id', $roles)->get()->pluck('user_id');
        $module = 'limit';
        $data = DealInvoice::where(['deleted_at' => null, 'status' => 1, 'status_2' => 0])
            ->whereMonth('date_end', $previousMonth)
            ->whereYear('date_end', $previousYear)
            ->whereIn('user_id', $users)
            ->with(['deal'])
            ->orderBy('date_end', 'desc');
        $customer_id = $request->customer_id;
        $catalogue_id = $request->catalogue_id;
        $status = $request->status;
        $date_end = $request->date_end; //ngày thanh toán
        $source_date_end = $request->source_date_end; //ngày kết thúc
        $date_start =  !empty($request->date_start) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_start)->format('Y-m-d') : '';
        $date_end = !empty($request->date_end) ? \Carbon\Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d') : '';
        if (is($request->keyword)) {
            $data =  $data->where('title', 'like', '%' . $request->keyword . '%');
        }
        if (isset($date_start) && !empty($date_start) && empty($date_end)) {
            $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_start . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && empty($date_start)) {
            $data =  $data->where('date_end', '>=', $date_end . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
        }
        if (isset($date_end) && !empty($date_end) && isset($date_start) && !empty($date_start)) {
            if ($date_end == $date_start) {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00');
            } else {
                $data =  $data->where('date_end', '>=', $date_start . ' 00:00:00')->where('date_end', '<=', $date_end . ' 23:59:59');
            }
        }
        if (!empty($request->user_id)) {
            $data = $data->where('user_id', $request->user_id);
        }
        if (!empty($request->status)) {
            $data = $data->where('status', $request->status);
        }
        $sumPrice = $data->get();
        $data = $data->paginate(env('APP_paginate'));
        if (is($request->status)) {
            $data->appends(['status' => $request->status]);
        }
        if (is($request->user_id)) {
            $data->appends(['user_id' => $request->user_id]);
        }
        if (is($request->date_end)) {
            $data->appends(['date_end' => $request->date_end]);
        }
        if (is($request->date_start)) {
            $data->appends(['date_start' => $request->date_start]);
        }
        $usersEmpty =  DealInvoice::where(['deleted_at' => null])->with('user')->whereIn('user_id', $users)->groupBy('user_id')->get();
        return view('deal.invoices.statistics', compact('data', 'module', 'usersEmpty', 'sumPrice'));
    }
}
