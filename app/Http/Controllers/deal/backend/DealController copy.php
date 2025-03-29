<?php

namespace App\Http\Controllers\deal\backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Customer;
use App\Models\Deal;
use App\Models\DealHistory;
use App\Models\DealRelationships;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use DateTime;

class DealController extends Controller
{
    protected $table = 'deals';
    public function __construct()
    {
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {

        /*$data = DealBrandTmp::get();
        foreach ($data as $item) {
            $date = explode("/", $item->date_end);
            if (count($date) == 1) {
                if (!empty($item->date_end)) {
                    $date2 = explode(".", $item->date_end);
                    if (!empty($date2) && !empty($date2[0])) {
                        $unixTimestamp = ($date2[0] - 25569) * 86400;
                        DealBrandTmp::where('id', $item->id)->update(['date_end' => Carbon::createFromFormat('Y-m-d', date('Y-m-d', $unixTimestamp))->format('d/m/Y'), 'type' => 1]);
                    }
                }
            }
        }
        $data = DealBrandTmp::where('type', 1)->get();
        foreach ($data as $item) {
            $date = explode("/", $item->date_end);
            DealBrandTmp::where('id', $item->id)->update(['date_end' => $date[1] . '/' . $date[0] . '/' . $date[2], 'type' => 0]);
        }
        $data = DealBrandTmp::get();
        foreach ($data as $item) {
            if (!empty($item->source_date_start)) {
                $date = explode("/", $item->source_date_start);
                if (count($date) == 1) {
                    $unixTimestamp = ($item->source_date_start - 25569) * 86400;
                    $date = date('d/m/Y', $unixTimestamp);
                    DealBrandTmp::where('id', $item->id)->update(['source_date_start' => $date, 'type' => 1]);
                }
            }
        }
        foreach ($data as $item) {
            if (!empty($item->source_date_end)) {
                $date = explode("/", $item->source_date_end);
                if (count($date) == 1) {
                    $unixTimestamp = ($item->source_date_end - 25569) * 86400;
                    $date = date('d/m/Y', $unixTimestamp);
                    DealBrandTmp::where('id', $item->id)->update(['source_date_end' => $date, 'type' => 1]);
                }
            }
        }
        $data = DealBrandTmp::where('type', 1)->get();
        foreach ($data as $item) {
            if (!empty($item->source_date_start)) {
                $date = explode("/", $item->source_date_start);
                DealBrandTmp::where('id', $item->id)->update(['source_date_start' => $date[1] . '/' . $date[0] . '/' . $date[2]]);
            }
        }
        foreach ($data as $item) {
            if (!empty($item->source_date_end)) {
                $date = explode("/", $item->source_date_end);
                DealBrandTmp::where('id', $item->id)->update(['source_date_end' => $date[1] . '/' . $date[0] . '/' . $date[2]]);
            }
        }
        foreach ($data as $item) {
            DealBrandTmp::where('id', $item->id)->update(['type' => 0]);
        } 
        $data = DealBrandTmp::get();
        foreach ($data as $item) {
            if (!empty($item->source_date_end)) {
                DealBrandTmp::where('id', $item->id)->update(['source_date_end' => Carbon::createFromFormat('d/m/Y', $item->source_date_end)->format('Y-m-d H:i:s')]);
            }
            if (!empty($item->date_end)) {
                DealBrandTmp::where('id', $item->id)->update(['date_end' => Carbon::createFromFormat('d/m/Y', $item->date_end)->format('Y-m-d H:i:s')]);
            }
            if (!empty($item->source_date_start)) {
                DealBrandTmp::where('id', $item->id)->update(['source_date_start' => Carbon::createFromFormat('d/m/Y', $item->source_date_start)->format('Y-m-d H:i:s')]);
            }
        }

        die;
        */
        //convert date_end
        $data = DealBrandTmp::get();
        foreach ($data as $item) {
            $date = explode("/", $item->date_end);
            if (count($date) == 1) {
                if (!empty($item->date_end)) {
                    $date2 = explode(".", $item->date_end);
                    if (!empty($date2) && !empty($date2[0])) {
                        $unixTimestamp = ($date2[0] - 25569) * 86400;
                        DealBrandTmp::where('id', $item->id)->update(['date_end' => Carbon::createFromFormat('Y-m-d', date('Y-m-d', $unixTimestamp))->format('d/m/Y H:i:s'), 'type' => 1]);
                    }
                }
            }
        }
        $data = DealBrandTmp::where('type', 1)->get();
        foreach ($data as $item) {
            $date = explode("/", $item->date_end);
            DealBrandTmp::where('id', $item->id)->update(['date_end' => $date[1] . '/' . $date[0] . '/' . $date[2]]);
        }
        $data = DealBrandTmp::where('type', 1)->get();
        foreach ($data as $item) {
            $date = explode("/", $item->date_end);
            DealBrandTmp::where('id', $item->id)->update(['type' => 0]);
        }

        $data = DealBrandTmp::get();
        foreach ($data as $item) {
            $date = explode("/", $item->source_date_start);
            if (count($date) == 1) {
                $unixTimestamp = ($item->source_date_start - 25569) * 86400;
                $date = date('d/m/Y', $unixTimestamp);
                DealBrandTmp::where('id', $item->id)->update(['source_date_start' => $date, 'type' => 1]);
            }
        }
        foreach ($data as $item) {
            $date = explode("/", $item->source_date_end);
            if (count($date) == 1) {
                $unixTimestamp = ($item->source_date_end - 25569) * 86400;
                $date = date('d/m/Y', $unixTimestamp);
                DealBrandTmp::where('id', $item->id)->update(['source_date_end' => $date, 'type' => 1]);
            }
        }



        $data = DealBrandTmp::where('type', 1)->get();
        foreach ($data as $item) {
            $date = explode("/", $item->source_date_start);
            DealBrandTmp::where('id', $item->id)->update(['source_date_start' => $date[1] . '/' . $date[0] . '/' . $date[2]]);
        }
        foreach ($data as $item) {
            $date = explode("/", $item->source_date_end);
            DealBrandTmp::where('id', $item->id)->update(['source_date_end' => $date[1] . '/' . $date[0] . '/' . $date[2]]);
        }
        foreach ($data as $item) {
            $date = explode("/", $item->date_end);
            DealBrandTmp::where('id', $item->id)->update(['type' => 0]);
        }

        $data = DealBrandTmp::get();
        foreach ($data as $item) {
            if (!empty($item->source_date_end)) {
                $source_date_end = DateTime::createFromFormat('Y-m-d', $item->source_date_end);
                if (empty($source_date_end)) {
                    DealBrandTmp::where('id', $item->id)->update([
                        'source_date_end' => Carbon::createFromFormat('d/m/Y', $item->source_date_end)->format('Y-m-d'),
                    ]);
                }
            }
            if (!empty($item->source_date_start)) {
                $source_date_start = DateTime::createFromFormat('Y-m-d', $item->source_date_start);
                if (empty($source_date_start)) {
                    DealBrandTmp::where('id', $item->id)->update([
                        'source_date_start' => Carbon::createFromFormat('d/m/Y', $item->source_date_start)->format('Y-m-d'),
                    ]);
                }
            }
            if (!empty($item->date_end)) {
                $date_end = DateTime::createFromFormat('Y-m-d H:i:s', $item->date_end);
                if (empty($date_end)) {
                    DealBrandTmp::where('id', $item->id)->update([
                        'date_end' => Carbon::createFromFormat('d/m/Y H:i:s', $item->date_end)->format('Y-m-d H:i:s'),
                    ]);
                }
            }
        }
        die;
        $module = $this->table;
        $data = Deal::with('deal_brand_tmps')->get();

        foreach ($data as $item) {
            Deal::where('id', $item->id)->update([
                'brand_id' => !empty($item->deal_brand_tmps) ? $item->deal_brand_tmps->brand_id : 0
            ]);
        }
        die;

        //cập nhập date_end
        $data = Deal::get();
        foreach ($data as $item) {
            $date = explode("/", $item->source_date_start);
            if (count($date) == 1) {
                $unixTimestamp = ($item->source_date_start - 25569) * 86400;
                // Convert Unix timestamp to a human-readable date
                $date = date('Y-m-d', $unixTimestamp);

                Deal::where('id', $item->id)->update(['source_date_start' => $date]);
            }
        }
        foreach ($data as $item) {
            $date = explode("/", $item->source_date_end);
            if (count($date) == 1) {
                $unixTimestamp = ($item->source_date_end - 25569) * 86400;
                // Convert Unix timestamp to a human-readable date
                $date = date('Y-m-d', $unixTimestamp);

                Deal::where('id', $item->id)->update(['source_date_end' => $date]);
            }
        }

        foreach ($data as $item) {
            $date = explode("/", $item->source_date_start);
            if (count($date) > 1) {

                $dateString = $item->source_date_start;
                // Create a DateTime object from the original date string
                $date = DateTime::createFromFormat('d/m/Y', $dateString);
                // Format the DateTime object to the desired format
                $formattedDate = $date->format('Y-m-d');
                Deal::where('id', $item->id)->update(['source_date_start' => $formattedDate]);
            }
        }
        foreach ($data as $item) {
            $date = explode("/", $item->source_date_end);
            if (count($date) > 1) {

                $dateString = $item->source_date_end;
                // Create a DateTime object from the original date string
                $date = DateTime::createFromFormat('d/m/Y', $dateString);
                // Format the DateTime object to the desired format
                $formattedDate = $date->format('Y-m-d');
                Deal::where('id', $item->id)->update(['source_date_end' => $formattedDate]);
            }
        }
        // $data = Deal::get();
        // foreach ($data as $item) {
        //     $price = 0;
        //     if (!empty($item->deal_relationships)) {
        //         foreach ($item->deal_relationships as $val) {
        //             $price += $val->price * $val->quantity;
        //         }
        //     }
        //     Deal::where('id', $item->id)->update([
        //         'price' => $price,
        //         'price_5' => $price
        //     ]);
        // }
        // die;
        // $data = Deal::orderBy('id', 'desc')->get();
        // foreach ($data as $item) {
        //     Deal::where('id', $item->id)->update([
        //         'date_end' => $item->created_at
        //     ]);
        // }
        // die;
        $data = DealBrandTmp::get();
        foreach ($data as $item) {
            Deal::where('id', $item->id_old)->update([
                'source_date_start' => $item->source_date_start,
                'source_date_end' => $item->source_date_end,
                'date_end' => $item->date_end,
            ]);
        }
        die;

        $data = Deal::orderBy('id', 'desc');
        if (is($request->keyword)) {
            $data =  $data->Where('title', 'like', '%' . $request->keyword . '%')
                ->orWhere('phone', 'like', '%' . $request->keyword . '%')
                ->orWhere('email', 'like', '%' . $request->keyword . '%')
                ->orWhere('website', 'like', '%' . $request->keyword . '%');
        }

        $data = $data->paginate(env('APP_paginate'));
        if (is($request->keyword)) {
            $data->appends(['keyword' => $request->keyword]);
        }
        return view('deal.backend.index', compact('data'));
    }


    public function create()
    {
        $category_products = dropdown(CategoryProduct::select('id', 'title')->get(), '', 'id', 'title');
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
        $data = [
            'catalogue_id' => $request->catalogue_id,
            'title' => $request->title,
            'status' => $request->status,
            'website' => $request->website,
            'price' => isset($request->price) ? str_replace('.', '', $request->price) : 0,
            'price_collected' => isset($request->price_collected) ? str_replace('.', '', $request->price_collected) : 0,
            'price_not_collected' => isset($request->price_not_collected) ? str_replace('.', '', $request->price_not_collected) : 0,
            'date_end' => Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d'),
            'customer_id' => $request->customer_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'type' => $request->type,
            'source' => $request->source,
            'source_description' => $request->source_description,
            'source_date_start' => Carbon::createFromFormat('d/m/Y', $request->source_date_start)->format('Y-m-d'),
            'source_date_end' =>  Carbon::createFromFormat('d/m/Y', $request->source_date_end)->format('Y-m-d'),
            'users_support' => json_encode($request->users_support),
            'users_join' => json_encode($request->users_join),
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'price_4' => $request->price_4,
            'price_5' => $request->price_5,
            'company' => $request->company,
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
            $taxInputOfItem =  $request->taxInputOfItem;
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
                'note' => 'Tạo thảo thuận thành công'
            ]);
        }
        return redirect()->route('deals.index')->with('success', "Thêm mới thỏa thuận thành công thành công");
    }



    public function edit($id)
    {
        $detail = Deal::with(['deal_relationships', 'category_products'])->find($id);
        if (!isset($detail)) {
            return redirect()->route('deals.index')->with('error', "Thảo thuận không tồn tại");
        }
        $category_products = dropdown(CategoryProduct::select('id', 'title')->get(), '', 'id', 'title');
        $customers = dropdown(Customer::select('id', 'name')->get(), 'Chọn khách hàng', 'id', 'name');
        $users = dropdown(User::select('id', 'name')->get(), '', 'id', 'name');
        $companies = array(
            'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT' => 'CÔNG TY TNHH PHẦN MỀM TÂM PHÁT',
            'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT' => 'CÔNG TY TNHH DỊCH VỤ CÔNG NGHỆ TÂM PHÁT'
        );
        $action = 'update';
        $products = Product::select('id', 'title', 'price')->get();
        $history = DealHistory::orderBy('id', 'desc')->get();
        return view('deal.backend.create', compact('detail', 'customers', 'users', 'companies', 'action', 'products', 'category_products', 'history'));
    }


    public function update(Request $request, $id)
    {
        $data = [
            'catalogue_id' => $request->catalogue_id,
            'title' => $request->title,
            'status' => $request->status,
            'website' => $request->website,
            'price' => isset($request->price) ? str_replace('.', '', $request->price) : 0,
            'price_collected' => isset($request->price_collected) ? str_replace('.', '', $request->price_collected) : 0,
            'price_not_collected' => isset($request->price_not_collected) ? str_replace('.', '', $request->price_not_collected) : 0,
            'date_end' => Carbon::createFromFormat('d/m/Y', $request->date_end)->format('Y-m-d'),
            'customer_id' => $request->customer_id,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'type' => $request->type,
            'source' => $request->source,
            'source_description' => $request->source_description,
            'source_date_start' => Carbon::createFromFormat('d/m/Y', $request->source_date_start)->format('Y-m-d'),
            'source_date_end' =>  Carbon::createFromFormat('d/m/Y', $request->source_date_end)->format('Y-m-d'),
            'users_support' => json_encode($request->users_support),
            'users_join' => json_encode($request->users_join),
            'price_1' => $request->price_1,
            'price_2' => $request->price_2,
            'price_3' => $request->price_3,
            'price_4' => $request->price_4,
            'price_5' => $request->price_5,
            'company' => $request->company,
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
                        'quantity' => !empty($product_quantity) ? $product_quantity[$key] : 0,
                        'unit' => !empty($product_unit) ? $product_unit[$key] : '',
                        'sales' => !empty($product_price_sale) ? $product_price_sale[$key] : 0,
                        'tax' => !empty($product_price_tax) ? $product_price_tax[$key] : 0,
                        'tax_price' => !empty($taxInputOfItem) ? $taxInputOfItem[$key] : 0,
                        'created_at' => Carbon::now(),
                    ];
                }
            }
            DealRelationships::insert($deal_relationships);
        }
        return redirect()->route('deals.index')->with('success', "Thêm mới thỏa thuận thành công thành công");
    }


    public function destroy($id)
    {
        //
    }
}
