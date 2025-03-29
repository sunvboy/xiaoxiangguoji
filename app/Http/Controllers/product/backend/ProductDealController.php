<?php

namespace App\Http\Controllers\product\backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductDeal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Components\Nestedsetbie;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use Validator;

class ProductDealController extends Controller
{
    protected $table = 'product_deals';
    protected $Nestedsetbie;
    protected $paginate = 20;
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'category_products'));
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  ProductDeal::orderBy('id', 'DESC')
            ->with(['user', 'product', 'product_deal_items']);
        $data =  $data->paginate(env('APP_paginate'));

        return view('product.backend.deals.index', compact('data'));
    }

    public function create()
    {
        Session::forget('productDealsOne');
        Session::forget('productDealsTwo');
        Session::forget('priceDeals');
        Session::forget('cartDeals');
        Session::forget('imageDeals');
        Session::forget('titleDeals');
        $catalogues = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $products = Product::where(['alanguage' => config('app.locale')])->orderBy('id', 'desc')->paginate($this->paginate);
        return view('product.backend.deals.create', compact('products', 'catalogues'));
    }


    public function store(Request $request)
    {
        //lấy danh sách sản phẩm chính
        $productID = Session::get('productDealsOne');
        $productID2 = Session::get('productDealsTwo');
        $priceDeals = Session::get('priceDeals');
        $products = Product::select('id', 'slug', 'title', 'image', 'price', 'price_sale', 'price_contact', 'code', 'inventoryQuantity', 'inventory', 'inventoryPolicy')
            ->whereIn('id', $productID2)
            ->orderBy('id', 'desc')
            ->get();
        // dD($priceDeals);
        if (!empty($productID)) {
            foreach ($productID as $key => $item) {
                $id = ProductDeal::insertGetId([
                    'product_id' => $item,
                    'userid_created' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                ]);
                if (!empty($id)) {
                    $_catalogue_relation_ship = [];
                    if (!empty($products)) {
                        foreach ($products as $v) {
                            if (count($v->product_versions) > 0) {
                                foreach ($v->product_versions as $val) {
                                    $rowid = md5($v->id . $val->title_version);
                                    $_catalogue_relation_ship[] = array(
                                        'product_id' => $v->id,
                                        'product_deal_id' => $id,
                                        'rowid' => $rowid,
                                        'price' => !empty($priceDeals) ? (!empty($priceDeals[$rowid]) ? str_replace('.', '', $priceDeals[$rowid]['price']) : 0) : 0,
                                        'created_at' => Carbon::now(),
                                    );
                                }
                            } else {
                                $rowid = md5($v->id);
                                $_catalogue_relation_ship[] = array(
                                    'product_id' => $v->id,
                                    'product_deal_id' => $id,
                                    'rowid' => $rowid,
                                    'price' => !empty($priceDeals) ? (!empty($priceDeals[$rowid]) ?  str_replace('.', '', $priceDeals[$rowid]['price']) : 0) : 0,
                                    'created_at' => Carbon::now(),
                                );
                            }
                        }
                    }
                    DB::table('product_deal_items')->insert($_catalogue_relation_ship);
                }
            }
        }
        return redirect()->route('product_deals.index')->with('success', "Thêm mới deals thành công");
    }


    public function edit($id)
    {
        Session::forget('productDealsOne');
        Session::forget('productDealsTwo');
        Session::forget('priceDeals');
        Session::forget('cartDeals');
        Session::forget('imageDeals');
        Session::forget('titleDeals');
        $detail  = ProductDeal::with('product_deal_items')->find($id);
        if (!isset($detail)) {
            return redirect()->route('category_products.index')->with('error', "Danh mục sản phẩm không tồn tại");
        }
        $arrProductTwo = $detail->product_deal_items->groupBy('product_id')->toArray();
        $productOnes  = Product::where('id', $detail->product_id)->paginate(1);
        $productTwos  = Product::whereIn('id', array_keys($arrProductTwo))->get();
        $productDeals = ProductDeal::pluck('product_id');

        $action = 'update';
        $tmpPriceDeals = [];
        if (!empty($detail->product_deal_items) && count($detail->product_deal_items) > 0) {
            foreach ($detail->product_deal_items as $item) {
                $tmpPriceDeals[$item->rowid] = [
                    'price' => number_format($item->price, '0', ',', '.'),
                ];
            }
        }
        Session::put('priceDeals', $tmpPriceDeals);
        Session::save();
        if (!empty($productTwos) && count($productTwos) > 0) {
            foreach ($productTwos as $item) {
                Session::push('productDealsTwo', $item->id);
            }
        }
        if (!empty($productDeals) && count($productDeals) > 0) {
            foreach ($productDeals as $item) {
                Session::push('productDealsOne', $item);
            }
        }
        if (!empty($productOnes) && count($productOnes) > 0) {
            foreach ($productOnes as $item) {
                Session::push('productDealsOne', $item->id);
            }
        }
        $priceDeals = Session::get('priceDeals');
        $catalogues = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $products = Product::where(['alanguage' => config('app.locale')])->whereNotIn('id', $productDeals)->orderBy('id', 'desc')->paginate($this->paginate);
        return view('product.backend.deals.edit', compact('detail', 'products', 'catalogues', 'productOnes', 'productTwos', 'action', 'priceDeals'));
    }

    public function update(Request $request, $id)
    {
        //xóa product_deal_items
        DB::table('product_deal_items')->where('product_deal_id', $id)->delete();
        //lấy danh sách sản phẩm chính
        $productID2 = Session::get('productDealsTwo');
        $priceDeals = Session::get('priceDeals');
        $products = Product::select('id', 'slug', 'title', 'image', 'price', 'price_sale', 'price_contact', 'code', 'inventoryQuantity', 'inventory', 'inventoryPolicy')
            ->whereIn('id', $productID2)
            ->orderBy('id', 'desc')
            ->get();
        if (!empty($id)) {
            $_catalogue_relation_ship = [];
            if (!empty($products)) {
                foreach ($products as $v) {
                    if (count($v->product_versions) > 0) {
                        foreach ($v->product_versions as $val) {
                            $rowid = md5($v->id . $val->title_version);
                            $_catalogue_relation_ship[] = array(
                                'product_id' => $v->id,
                                'product_deal_id' => $id,
                                'rowid' => $rowid,
                                'price' => !empty($priceDeals) ? (!empty($priceDeals[$rowid]) ? str_replace('.', '', $priceDeals[$rowid]['price']) : 0) : 0,
                                'created_at' => Carbon::now(),
                            );
                        }
                    } else {
                        $rowid = md5($v->id);
                        $_catalogue_relation_ship[] = array(
                            'product_id' => $v->id,
                            'product_deal_id' => $id,
                            'rowid' => $rowid,
                            'price' => !empty($priceDeals) ? (!empty($priceDeals[$rowid]) ?  str_replace('.', '', $priceDeals[$rowid]['price']) : 0) : 0,
                            'created_at' => Carbon::now(),
                        );
                    }
                }
            }
            DB::table('product_deal_items')->insert($_catalogue_relation_ship);
        }
        return redirect()->route('product_deals.index')->with('success', "Cập nhập deals thành công");
    }
    public function pagination(Request $request)
    {
        $keyword = $request->keyword;
        $catalogues = $request->catalogues;
        $products = Product::select('id', 'slug', 'title', 'image', 'price', 'price_sale', 'price_contact', 'code', 'inventoryQuantity', 'inventory', 'inventoryPolicy')->where(['alanguage' => config('app.locale')])->orderBy('id', 'desc');
        if (!empty($keyword)) {
            $products =  $products->where('products.title', 'like', '%' . $keyword . '%');
            $products =  $products->orWhere('products.code', 'like', '%' . $keyword . '%');
        }
        //xử lý danh mục
        $products = $products->join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')
            ->where('catalogues_relationships.module', '=', 'products');
        if (!empty($catalogues)) {
            $products =  $products->where('catalogues_relationships.catalogueid', $catalogues);
        }
        //xử lí
        $productDealsOne = Session::get('productDealsOne');
        if (!empty($productDealsOne)) {
            $products =  $products->whereNotIn('id', $productDealsOne);
        }
        $productDealsTwo = Session::get('productDealsTwo');
        if (!empty($productDealsTwo)) {
            $products =  $products->whereNotIn('id', $productDealsTwo);
        }
        $products = $products->paginate($this->paginate);
        return view('product.backend.deals.common.product', compact('products'))->render();
    }
    public function saveProductOne(Request $request)
    {
        $ids = $request->ids;
        $type = $request->type;
        $id = $request->id;
        $id_checked = $request->id_checked;
        $keyword = $request->keyword;
        $check = $request->productOne;
        $idSessions = Session::get('productDealsOne');
        if (!empty($ids)) {
            if (!empty($idSessions)) {
                foreach ($ids as $id) {
                    $idSessions = Session::push('productDealsOne', $id);
                }
            } else {
                Session::put('productDealsOne', $ids);
                Session::save();
            }
        }
        $idSessions = Session::get('productDealsOne');
        //xóa 1 bản ghi
        if (!empty($type) && !empty($id) && $type == 'delete') {
            $idSessions = array_filter($idSessions, function ($value) use ($id) {
                return $value !== $id;
            });
            Session::put('productDealsOne', $idSessions);
            Session::save();
        }
        //xóa nhiều bản ghi
        if (!empty($type) && !empty($id_checked) && $type == 'delete-all') {
            $idSessions = array_diff($idSessions, $id_checked);
            Session::put('productDealsOne', $idSessions);
            Session::save();
        }
        $productID = !empty($idSessions) ? array_unique($idSessions) : [];
        $productOnes = Product::select('id', 'slug', 'title', 'price', 'price_sale', 'price_contact', 'image', 'inventoryQuantity', 'code')
            ->whereIn('id', $productID);
        if (!empty($keyword)) {
            $productOnes =  $productOnes->where('products.title', 'like', '%' . $keyword . '%');
            $productOnes =  $productOnes->orWhere('products.code', 'like', '%' . $keyword . '%');
        }
        $productOnes = $productOnes->paginate(5);

        return view('product.backend.deals.common.product_one', compact('productOnes', 'check'))->render();
    }
    public function saveProductTwo(Request $request)
    {
        $priceDeals = Session::get('priceDeals');
        $ids = $request->ids;
        $type = $request->type;
        $id = $request->id;
        $id_checked = $request->id_checked;
        $keyword = $request->keyword;
        $check = $request->productOne;
        $idSessions = Session::get('productDealsTwo');
        if (!empty($ids)) {
            if (!empty($idSessions)) {
                foreach ($ids as $id) {
                    $idSessions = Session::push('productDealsTwo', $id);
                }
            } else {
                Session::put('productDealsTwo', $ids);
                Session::save();
            }
        }
        $idSessions = Session::get('productDealsTwo');
        //xóa 1 bản ghi
        if (!empty($type) && !empty($id) && $type == 'delete') {
            $idSessions = array_filter($idSessions, function ($value) use ($id) {
                return $value !== $id;
            });
            Session::put('productDealsTwo', $idSessions);
            Session::save();
        }
        //xóa nhiều bản ghi
        if (!empty($type) && !empty($id_checked) && $type == 'delete-all') {
            $idSessions = array_diff($idSessions, $id_checked);
            Session::put('productDealsTwo', $idSessions);
            Session::save();
        }
        $productID = !empty($idSessions) ? array_unique($idSessions) : [];
        $productTwos = Product::select('id', 'slug', 'title', 'price', 'price_sale', 'price_contact', 'image', 'inventoryQuantity', 'code')
            ->whereIn('id', $productID);
        if (!empty($keyword)) {
            $productTwos =  $productTwos->where('products.title', 'like', '%' . $keyword . '%');
            $productTwos =  $productTwos->orWhere('products.code', 'like', '%' . $keyword . '%');
        }
        $productTwos = $productTwos->get();

        /*  if (!empty($productTwos)) {
            foreach ($productTwos as $product) {
                $rowid = $product->id;
                $priceProduct = getPrice(array('price' => $product['price'], 'price_sale' => $product['price_sale'], 'price_contact' =>
                $product['price_contact']));
                $titleDeals[$rowid] = $product->title;
                $imageDeals[$rowid] = !empty($request->image) ? $request->image : $product->image;
                if (count($product->product_versions) > 0) {
                    foreach ($product->product_versions as $val) {
                        $cart[$rowid] = [
                            "id" => $product->id,
                            "title" => $product->title,
                            "image" => !empty($request->image) ? $request->image : $product->image,
                            "price" => $priceProduct['price_final_none_format'],
                            "options" => array(
                                'id_version' => $val->id_version,
                                'title_version' => $val->title_version,
                            ),
                        ];
                    }
                } else {
                    $cart[$rowid] = [
                        "id" => $product->id,
                        "title" => $product->title,
                        "image" => !empty($request->image) ? $request->image : $product->image,
                        "price" => $priceProduct['price_final_none_format'],
                    ];
                    $cart[$rowid] = [
                        "id" => $product->id,
                        "title" => $product->title,
                        "image" => !empty($request->image) ? $request->image : $product->image,
                        "price" => $priceProduct['price_final_none_format'],
                    ];
                }
            }
        }
        Session::put('cartDeals', $cart);
        Session::put('titleDeals', $titleDeals);
        Session::put('imageDeals', $imageDeals);
        Session::save(); */
        return view('product.backend.deals.common.product_two', compact('productTwos', 'check', 'priceDeals'))->render();
    }
    public function changePrice(Request $request)
    {
        $rowid = $request->rowid;
        $price = $request->price;

        $priceDeals = Session::get('priceDeals');
        if (isset($priceDeals[$rowid])) {
            $priceDeals[$rowid]['price'] =  $price;
        } else {
            $priceDeals[$rowid] = [
                "price" => $price
            ];
        }
        Session::put('priceDeals', $priceDeals);
        Session::save();
    }
}
