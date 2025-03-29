<?php

namespace App\Http\Controllers\product\backend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductTmp;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use App\Components\Helper;
use App\Models\Attribute;
use App\Models\CategoryAttribute;
use Image;

class ProductTmpController extends Controller
{
    protected $table = 'product_tmps';
    protected $Helper;
    public function __construct()
    {
        $this->Helper = new Helper();
    }
    public function index()
    {
        $data =  ProductTmp::where('status', null)->orderBy('id', 'DESC');
        $data =  $data->paginate(env('APP_paginate'));
        return view('product.backend.tmps.index', compact('data'));
    }
    public function create(Request $request)
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://127.0.0.1:5000/products',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        $response =  json_decode($response, TRUE);
        $_data = [];
        if (!empty($response)) {
            foreach ($response as $item) {
                $_data[] = [
                    'name' => $item['name'],
                    'tag_name' => $item['tag_name'],
                    'link' => $item['link'] . '.js',
                    'category_id' => json_encode($item['category_id']),
                ];
            }
            ProductTmp::insert($_data);
        }
        return redirect()->route('product_tmps.index')->with('success', "lấy dữ liệu từ server thành công");
    }
    public function crawler()
    {
        $data = ProductTmp::where('status', null)->orderBy('id', 'asc')->get();
        foreach ($data as $item) {
            $catalogue_id = json_decode($item->category_id);
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $item->link,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $response = json_decode($response, TRUE);
            if (!empty($response)) {
                //lay ma san pham
                $type = 'simple';
                if (!empty($response['options'])) {
                    if (count($response['options']) > 2) {
                        $type = 'variable';
                    }
                }
                //image_json
                $image_json = [];
                if (!empty($response['images'])) {
                    foreach ($response['images'] as $image) {
                        if (!strpos($image, 'icon')) {
                            $image_json[] = $image;
                        }
                    }
                }
                //thêm tag $response['vendor']
                $checkTag = Tag::where('title', $response['vendor'])->first();
                $tag_id = [];
                if (empty($checkTag)) {
                    $tag_id[] = Tag::insertGetId([
                        'title' => $response['vendor'],
                        'slug' => slug($response['vendor']),
                        'module' => 'products',
                        'publish' => 0,
                        'userid_created' => Auth::user()->id,
                        'created_at' => Carbon::now(),
                        'alanguage' => config('app.locale'),
                    ]);
                } else {
                    $tag_id[] = $checkTag->id;
                }
                //attributes
                $attr_id = [];
                $attribute_catalogue = [];
                if (!empty($response['options'])) {
                    $i = 0;
                    foreach ($response['options'] as $a) {
                        $checkCategoryAttribute = CategoryAttribute::where('title', $a['name'])->first();
                        if (!empty($checkCategoryAttribute)) {
                            $attribute_catalogue[] = $checkCategoryAttribute->id;
                            if (!empty($a['values'])) {
                                foreach ($a['values'] as $q) {
                                    if (!empty($q)) {
                                        if ($q != 'N/A') {
                                            $checkAttr = Attribute::where('title', $q)->first();
                                            if (empty($checkAttr)) {
                                                $attr_id[$i][] = Attribute::insertGetId([
                                                    'title' => $q,
                                                    'slug' => slug($q),
                                                    'catalogueid' => $checkCategoryAttribute->id,
                                                    'publish' => 0,
                                                    'userid_created' => Auth::user()->id,
                                                    'created_at' => Carbon::now(),
                                                    'alanguage' => config('app.locale'),
                                                ]);
                                            } else {
                                                $attr_id[$i][] = $checkAttr->id;
                                            }
                                        }
                                    }
                                }
                            }
                            $i++;
                        }
                    }
                }

                //version_json
                $checkbox[] = 1;
                $attribute = $attr_id;
                //thêm sản phẩm
                $code = CodeRender('products');
                if ($response['price_max'] > $response['price_min']) {
                    $price_sale = $response['price_min'] / 100;
                } else {
                    $price_sale = 0;
                }
                $_data = [
                    'title' => $response['title'],
                    'slug' => $response['handle'],
                    'description' => $response['description'],
                    'code' => $code,
                    'image' => $response['featured_image'],
                    'image_json' =>  json_encode($image_json),
                    'catalogue_id' => $catalogue_id[1],
                    'catalogue' => $item->category_id,
                    'price' => isset($response['price_max']) ?  $response['price_max'] / 100 : 0,
                    'price_sale' => $price_sale,
                    'price_contact' => 0,
                    'publish' => 0,
                    'userid_created' => Auth::user()->id,
                    'created_at' => Carbon::now(),
                    'version_json' => base64_encode(json_encode(array($checkbox, $attribute_catalogue, $attribute))),
                    'alanguage' => 'vi',
                    'type' => $type,
                    'meta_title'  => $response['pagetitle'],
                    'meta_description'  => $response['metadescription'],
                    'website' => 'maisononline'
                ];

                $id = Product::insertGetId($_data);
                if ($id > 0) {
                    //thêm router
                    DB::table('router')->insert([
                        'moduleid' => $id,
                        'module' =>  'products',
                        'slug' => $response['handle'],
                        'created_at' => Carbon::now(),
                        'alanguage' => 'vi',
                    ]);
                    //thêm vào bảng catalogue_relationship
                    $this->Helper->catalogue_relation_ship($id, $catalogue_id[1], $catalogue_id, 'products');
                    //thêm vào bảng tags_relationships
                    $this->Helper->tags_relationships($id, $tag_id, 'products');
                    //thêm vào bảng attributes_relationships

                    $this->Helper->attributes_relationships($id, $attribute, $catalogue_id);

                    $address = \App\Models\Address::select('id')->where('alanguage', config('app.locale'))->get();
                    $_insert_version = [];
                    if (!empty($attr_id)) {
                        foreach ($attr_id as $q => $n) {
                            $id_attr = Attribute::where('id', $n)->pluck('id');
                            $title_attr = Attribute::where('id', $n)->pluck('title');
                            $_insert_version[]  = array(
                                'product_id' => $id,
                                'id_version' => json_encode($id_attr),
                                'title_version' => json_encode($title_attr),
                                'code_version' => $code . '-' . $q,
                                'image_version' => '',
                                'price_version' => isset($response['price_max']) ?  $response['price_max'] / 100 : 0,
                                'price_sale_version' => $price_sale,
                                'price_import_version' => null,
                                '_stock_status' => 0,
                                '_outstock_status' => 0,
                                '_ships_weight' => null,
                                '_ships_length' => null,
                                '_ships_width' => null,
                                '_ships_height' => null,
                                'created_at' => Carbon::now(),
                                'userid_created' => Auth::user()->id,
                            );
                        }
                    }
                    $_insert_stock = [];
                    if (!empty($_insert_version)) {
                        foreach ($_insert_version as $key => $version) {
                            $id_insert = \App\Models\ProductVersion::insertGetId($version);
                            if ($id_insert > 0) {
                                if (!empty($address)) {
                                    foreach ($address as $ks => $vs) {
                                        $_insert_stock[]  = array(
                                            'address_id' => $vs->id,
                                            'product_id' => $id,
                                            'product_version_id' => $id_insert,
                                            'type' => 'variable',
                                            'created_at' => Carbon::now(),
                                            'user_id' => Auth::user()->id,
                                        );
                                    }
                                }
                            }
                        }
                    }
                    if (!empty($_insert_stock)) {
                        \App\Models\ProductStock::insert($_insert_stock);
                    }
                }
            }
            //xong cập nhập trạng thái
            ProductTmp::where('id', $item->id)->update(['status' => 'done']);
        }
        return redirect()->route('product_tmps.index')->with('success', "lấy dữ liệu từ server thành công");
    }
    public function crawler_version()
    {
        $data = Product::select('id', 'code', 'version_json', 'price', 'price_sale')->where('crawler_version', null)->get();
        if (!empty($data)) {
            foreach ($data as $item) {
                $_insert_version = [];
                $version_json = json_decode(base64_decode($item->version_json), true);
                $attribute = !empty($version_json[2]) ? $version_json[2] : [];
                if (!empty($attribute[0]) && !empty($attribute[1])) {
                    $news = collect($attribute[0])->crossJoin($attribute[1])->all();
                    if (!empty($news)) {
                        foreach ($news as $q => $n) {
                            $id_attr = Attribute::whereIn('id', $n)->pluck('id');
                            $title_attr = Attribute::whereIn('id', $n)->pluck('title');
                            $_insert_version[]  = array(
                                'product_id' => $item->id,
                                'id_version' => json_encode($id_attr),
                                'title_version' => json_encode($title_attr),
                                'code_version' => $item->code . '-' . $q,
                                'image_version' => '',
                                'price_version' => $item->price,
                                'price_sale_version' => $item->price_sale,
                                'price_import_version' => null,
                                '_stock_status' => 0,
                                // '_stock' => !empty($_stock[$key]) ? $_stock[$key] : '',
                                '_outstock_status' => 0,
                                '_ships_weight' => null,
                                '_ships_length' => null,
                                '_ships_width' => null,
                                '_ships_height' => null,
                                'created_at' => Carbon::now(),
                                'userid_created' => Auth::user()->id,
                            );
                        }
                    }
                }
                if (!empty($_insert_version)) {
                    foreach ($_insert_version as $key => $val) {
                        $id_insert = \App\Models\ProductVersion::insertGetId($val);
                        if ($id_insert > 0) {
                            if (!empty($address)) {
                                foreach ($address as $ks => $vs) {
                                    $_insert_stock[]  = array(
                                        'address_id' => $vs->id,
                                        'product_id' => $val['product_id'],
                                        'product_version_id' => $id_insert,
                                        'type' => 'variable',
                                        'created_at' => Carbon::now(),
                                        'user_id' => Auth::user()->id,
                                    );
                                }
                            }
                        }
                    }
                }
                // \App\Models\ProductStock::insert($_insert_stock);
                Product::where('id', $item->id)->update(['crawler_version' => 'done']);
            }
        }

        return redirect()->route('product_tmps.index')->with('success', "lấy dữ liệu từ server thành công");
    }
    public function crawler_stock()
    {
        $data = \App\Models\ProductVersion::where('crawler_stock', null)->get();
        $address = \App\Models\Address::select('id')->where('alanguage', config('app.locale'))->get();
        if (!empty($data)) {
            foreach ($data as $key => $item) {
                if (!empty($address)) {
                    foreach ($address as $ks => $vs) {
                        \App\Models\ProductStock::create(array(
                            'address_id' => $vs->id,
                            'product_id' => $item->product_id,
                            'product_version_id' => $item->id,
                            'type' => 'variable',
                            'created_at' => Carbon::now(),
                            'user_id' => Auth::user()->id,
                        ));
                    }
                }
                \App\Models\ProductVersion::where('id', $item->id)->update(['crawler_stock' => 'done']);
            }
        }
        return redirect()->route('product_tmps.index')->with('success', "lấy dữ liệu từ server thành công");
    }
    public function crawler_image()
    {
        $data = Product::select('id', 'image_json')->where('website', 'maisononline')->get();
        foreach ($data as $item) {
            $images = json_decode($item->image_json, TRUE);
            if (!empty($images)) {
                foreach ($images as $image) {
                    $name = substr($image, strrpos($image, '/') + 1);
                    $name_gen = pathinfo($name, PATHINFO_FILENAME) . '.webp';
                    $base_path = base_path('upload/childsplayclothing');
                    if (!file_exists($base_path)) {
                        mkdir($base_path, 666, true);
                    }
                    Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
                }
            }
            Product::where('id', $item->id)->update(['crawler_image' => 'done']);
        }
        return redirect()->route('product_tmps.index')->with('success', "lấy dữ liệu từ server thành công");
    }
}
