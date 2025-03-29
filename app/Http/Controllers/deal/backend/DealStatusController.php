<?php

namespace App\Http\Controllers\deal\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealView;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DealStatusController extends Controller
{
    protected $table = 'deals';
    public function __construct()
    {
        $customers = dropdown(Customer::select('id', 'name')->get(), '', 'id', 'name');
        View::share(['module' => $this->table, 'active' => 'maintain', 'customers' => $customers]);
    }

    public function awaiting(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'status' => 8, 'catalogue_id' => 1])->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        return view('deal.index.awaiting', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function newly(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'catalogue_id' => 1])->whereDate('created_at', now()->toDateString())
            ->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        return view('deal.index.newly', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function using(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'catalogue_id' => 1, 'type' => 1])->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        return view('deal.index.using', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function is(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'catalogue_id' => 1, 'type' => 1])
            ->where('source_date_end', '>', Carbon::today())
            ->where('source_date_end', '<', Carbon::now()->addMonth()->endOfMonth())
            ->with(['user_created', 'user_updated', 'deal_relationships'])
            ->orderBy('source_date_end', 'asc')
            ->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        return view('deal.index.is', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function suspend(Request $request)
    {
        $module = $this->table;
        /*$data = Deal::where(['deleted_at' => null, 'suspend' => 1, 'catalogue_id' => 1])
            ->where('source_date_end', '<=', Carbon::today())
            ->where('source_date_end', '>=', Carbon::now()->subMonth()->endOfMonth())
            ->with(['user_created', 'user_updated', 'deal_relationships'])
            ->orderBy('source_date_end', 'desc')
            ->orderBy('id', 'desc'); */
        $data = Deal::where(['deleted_at' => null, 'status' => 7, 'catalogue_id' => 1])
            ->orderBy('source_date_end', 'desc')
            ->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        return view('deal.index.suspend', compact('data', 'category_products', 'deal_views', 'products'));
    }
    public function expired(Request $request)
    {
        $module = $this->table;
        $data = Deal::where(['deleted_at' => null, 'type' => 0, 'catalogue_id' => 1])->with(['user_created', 'user_updated', 'deal_relationships'])->orderBy('type', 'desc')->orderBy('id', 'desc');
        $data = $data->paginate(env('APP_paginate'));
        // if (!empty($data)) {
        //     foreach ($data as $item) {
        //         if (!empty($item->deal_relationships)) {
        //             if (count($item->deal_relationships) > 0) {
        //                 $deal_relationships = $item->deal_relationships;
        //                 if (!empty($deal_relationships)) {
        //                     $deal_relationships = collect($deal_relationships)->pluck('duy_tri')->toArray();
        //                 }
        //                 Deal::where('id', $item->id)->update([
        //                     'tag_id' => json_encode($deal_relationships)
        //                 ]);
        //             }
        //         }
        //     }
        // }
        // die;
        $category_products = dropdown(CategoryProduct::select('id', 'title')->where('parentid', 0)->get(), '', 'id', 'title');
        $products = dropdown(Product::select('id', 'title')->get(), '', 'title', 'title');
        $deal_views = DealView::where('type', 'maintain')->orderBy('order', 'asc')->get();
        return view('deal.index.expired', compact('data', 'category_products', 'deal_views', 'products'));
    }
}
