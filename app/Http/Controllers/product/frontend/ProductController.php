<?php

namespace App\Http\Controllers\product\frontend;

use App\Components\Comment as CommentHelper;
use App\Components\Polylang;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Attribute;
use App\Models\CategoryProduct;
use Illuminate\Http\Request;
use App\Components\System;
use Session;

class ProductController extends Controller
{
    protected $comment;
    protected $system;
    public function __construct()
    {
        $this->comment = new CommentHelper();
        $this->system = new System();
    }
    public function index(Request $request, $slug = "", $id = 0)
    {
        // Session::forget('cart');
        $segments = request()->segments();
        $slug = end($segments);
        $detail = Product::where(['alanguage' => config('app.locale'), 'slug' => $slug, 'publish' => 0])
            ->with(['fields', 'brands', 'product_versions', 'deals', 'brand'])
            ->with(['product_stocks'])
            ->first();
        $fields = [];
        if (!empty($detail->fields) && count($detail->fields) > 0) {
            foreach ($detail->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? $item->meta_value : '';
            }
        }
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        //comment
        $comment_view =  $this->comment->comment(array('id' => $detail->id, 'sort' => 'id'), 'products');
        //end
        //lấy danh mục cha
        $detailCatalogue = $detail->detailCategoryProduct;
        //breadcrumb
        $breadcrumb = [];
        if (!empty($detailCatalogue)) {
            $breadcrumb = CategoryProduct::select('title', 'slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detailCatalogue->lft)->where('rgt', '>=', $detailCatalogue->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        }
        //lấy brands
        $brand = Brand::select('id', 'title', 'slug')->whereIn('id', $detail->brands->pluck('brand_id'))->first();
        //sản phẩm liên quan
        $productSame =  Product::join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')
            ->join('category_products', 'category_products.id', '=', 'products.catalogue_id')
            ->where('catalogues_relationships.module', '=', 'products');
        $productSame =  $productSame->where('catalogues_relationships.catalogueid', $detailCatalogue->id)->where('products.id', '!=', $detail->id);
        $productSame =  $productSame->orderBy('products.order', 'asc')->orderBy('products.id', 'desc');
        $productSame =  $productSame->select('category_products.title as titleC', 'category_products.slug as slugC', 'products.id', 'products.title', 'products.image_json', 'products.image', 'products.slug', 'products.price', 'products.price_sale', 'products.price_contact');
        // $productSame =  $productSame->with('getTags');
        $productSame =  $productSame->limit(20);
        $productSame =  $productSame->get();
        //sản phẩm đã Xem
        $recently_viewed = Session::get('products.recently_viewed');
        if (!empty($recently_viewed)) {
            if (!in_array($detail->id, $recently_viewed)) {
                Session::push('products.recently_viewed', $detail->id);
            }
        } else {
            Session::push('products.recently_viewed', $detail->id);
        }
        //sản phẩm mua kèm
        /* $deals = $detail->deals->groupBy('product_id')->toArray();
        $productDeals = Product::select('id', 'slug', 'title', 'image', 'price', 'price_sale', 'price_contact', 'code', 'inventoryQuantity', 'inventory', 'inventoryPolicy')
            ->whereIn('id', array_keys($deals))
            ->with('product_versions')
            ->get();$ishomeProduct = Product::select('category_products.title as titleC', 'category_products.slug as slugC', 'products.id', 'products.title', 'products.image_json', 'products.image', 'products.slug', 'products.price', 'products.price_sale', 'products.price_contact')
            ->join('category_products', 'category_products.id', '=', 'products.catalogue_id')
            ->where(['products.alanguage' => config('app.locale'), 'products.publish' => 0, 'products.ishome' => 1])
            ->limit(520)->get(); */


        $policyProduct = \App\Models\CategorySlide::select('title', 'id')->where(['alanguage' => config('app.locale'), 'keyword' => 'policyProduct'])->with('slides')->first();

        $seo['canonical'] =  $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        $polylang = langURLFrontend('products', config('app.locale'), $detail->id, '\App\Models\Product');
        if (!empty($polylang)) {
            foreach ($polylang as $key => $item) {
                $fcSystem['language_' . $key] = $item;
            }
        }
        return view('product.frontend.product.index', compact('fcSystem',  'detail', 'seo', 'productSame', 'detailCatalogue', 'fields', 'breadcrumb', 'comment_view', 'brand', 'policyProduct'));
    }
}
