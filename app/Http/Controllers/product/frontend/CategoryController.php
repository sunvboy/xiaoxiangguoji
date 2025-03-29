<?php

namespace App\Http\Controllers\product\frontend;

use App\Http\Controllers\Controller;
use App\Models\CategoryProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Components\System;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $system;
    protected $paginate = 20;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request, $slug = "", $id = 0)
    {
        $segments = request()->segments();
        $slug = end($segments);
        $sort = '';
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $detail = CategoryProduct::where(['alanguage' => config('app.locale'), 'slug' => $slug, 'publish' => 0])->with(['children', 'brands_relationships', 'attributes_relationships'])->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        //bộ lọc
        // $attribute_catalogue = getListAttr($detail->attrid);
        //data product
        $data =  Product::join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')
            ->where('catalogues_relationships.module', '=', 'products')
            ->join('category_products', 'category_products.id', '=', 'products.catalogue_id')
            ->with(['field' => function ($q) {
                $q->select('module_id', 'meta_value')->where('meta_key', 'config_colums_json_feature');
            }])
            ->select('category_products.title as titleC', 'category_products.slug as slugC', 'products.id', 'products.title', 'products.slug', 'products.image', 'products.price', 'products.price_sale', 'products.price_contact', 'products.image_json');
        if (!empty($detail->id)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $detail->id);
        }
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (count($sort) == 2) {
                $data =  $data->orderBy($sort[0], $sort[1]);
            } else {
                return redirect()->route('routerURL', ['slug' => $detail->slug]);
            }
        } else {
            $data =  $data->orderBy('products.id', 'desc');
        }
        /*$data = $data->with([
            'products_versions' => function ($q) {
                $q->groupBy('products_versions.product_color_id');
            }
        ]); */
        // $data =  $data->with(['getTags']);
        $data =  $data->paginate($this->paginate);
        // if (is($sort)) {
        //     $data->appends(['sort' => $request->sort]);
        // }
        //end
        // breadcrumb
        $breadcrumb = CategoryProduct::select('title', 'slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        //lấy nhóm thuộc tính
        $attribute_tmp = [];
        if (!empty($detail->attributes_relationships) && count($detail->attributes_relationships) > 0) {
            foreach ($detail->attributes_relationships as $item) {
                if (!empty($item->attributes)) {
                    $attribute_tmp[] = array(
                        'id' => $item->attributes->id,
                        'title' => $item->attributes->title,
                        'titleC' => $item->attributes->titleC,
                        'keyword' => $item->attributes->slugC,
                    );
                }
            }
        }
        $attributes = collect($attribute_tmp)->groupBy('titleC')->all();
        $brandFilter = !empty($detail->brands_relationships) ? $detail->brands_relationships : [];
        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        $polylang = langURLFrontend('category_products', config('app.locale'), $detail->id, '\App\Models\CategoryProduct');
        if (!empty($polylang)) {
            foreach ($polylang as $key => $item) {
                $fcSystem['language_' . $key] = $item;
            }
        }
        $module = 'category';
        return view('product.frontend.category.index', compact('fcSystem', 'module', 'detail', 'seo', 'data', 'breadcrumb', 'attributes', 'brandFilter'));
    }
    //Page: Sản phẩm
    public function products()
    {
        $page = \App\Models\Page::where(['alanguage' => config('app.locale'), 'page' => 'products', 'publish' => 0])->select('meta_title', 'meta_description', 'image', 'title', 'description')->first();

        $data = \App\Models\Product::select('category_products.title as titleC', 'category_products.slug as slugC', 'products.id', 'products.title', 'products.slug', 'products.image', 'products.price', 'products.price_sale', 'products.price_contact', 'products.image_json')
            ->join('category_products', 'category_products.id', '=', 'products.catalogue_id')
            ->where(['products.alanguage' => config('app.locale'), 'products.publish' => 0])
            // ->with('getTags')
            ->with(['field' => function ($q) {
                $q->select('module_id', 'meta_value')->where('meta_key', 'config_colums_json_feature');
            }])
            ->orderBy('products.price', 'desc')->orderBy('products.price_sale', 'desc')->orderBy('products.id', 'desc')
            ->paginate($this->paginate);

        $attribute_tmp = \App\Models\CategoryAttribute::select('id', 'title', 'slug as keyword')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 0])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->with('listAttr')
            ->get();
        $attributes = [];
        if (!empty($attribute_tmp)) {
            foreach ($attribute_tmp as $item) {
                if (count($item->listAttr)) {
                    foreach ($item->listAttr as $attr) {
                        $attributes[] = array(
                            'id' => $attr->id,
                            'title' => $attr->title,
                            'titleC' => $item->title,
                            'keyword' => $item->keyword,
                        );
                    }
                }
            }
        }
        $attributes = collect($attributes)->groupBy('titleC')->all();
        $brandFilter = \App\Models\Brand::select('id', 'title')
            ->where(['publish' => 0, 'alanguage' => config('app.locale')])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        $module = 'products';
        return view('product.frontend.category.products', compact('seo', 'module', 'page', 'fcSystem', 'data', 'attributes', 'brandFilter'));
    }
    //Page: Tìm kiếm
    public function search(Request $request)
    {
        $keyword = removeutf8($request->keyword);
        $sort = '';
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $data =  Product::where(['products.alanguage' => config('app.locale'), 'products.publish' => 0])
            ->join('category_products', 'category_products.id', '=', 'products.catalogue_id')
            ->with(['field' => function ($q) {
                $q->select('module_id', 'meta_value')->where('meta_key', 'config_colums_json_feature');
            }])->select('category_products.title as titleC', 'category_products.slug as slugC', 'products.id', 'products.title', 'products.slug', 'products.image', 'products.price', 'products.price_sale', 'products.price_contact', 'products.image_json');
        if (!empty($keyword)) {
            $data =  $data->where('products.title', 'like', '%' . $keyword . '%');
        }
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (!empty($sort) && count($sort) == 2) {
                $data =  $data->orderBy($sort[0], $sort[1]);
            } else {
                return redirect()->route('search', ['keyword' => $keyword]);
            }
        } else {
            $data =  $data->orderBy('products.price', 'desc')->orderBy('products.price_sale', 'desc')->orderBy('products.id', 'desc');
        }
        $data =  $data->with('getTags');
        $data =  $data->paginate($this->paginate);
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($sort)) {
            $data->appends(['sort' => $request->sort]);
        }
        $attribute_tmp = \App\Models\CategoryAttribute::select('id', 'title', 'slug as keyword')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 0])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->with('listAttr')
            ->get();
        $attributes = [];
        if (!empty($attribute_tmp)) {
            foreach ($attribute_tmp as $item) {
                if (count($item->listAttr)) {
                    foreach ($item->listAttr as $attr) {
                        $attributes[] = array(
                            'id' => $attr->id,
                            'title' => $attr->title,
                            'titleC' => $item->title,
                            'keyword' => $item->keyword,
                        );
                    }
                }
            }
        }
        $attributes = collect($attributes)->groupBy('titleC')->all();
        $brandFilter = \App\Models\Brand::select('id', 'title')
            ->where(['publish' => 0, 'alanguage' => config('app.locale')])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  trans('index.SearchResults') . ": " . $keyword;
        $seo['meta_description'] = '';
        $seo['meta_image'] = '';
        $fcSystem = $this->system->fcSystem();
        //$attribute_catalogue = \App\Models\CategoryAttribute::where(['ishome' => 1, 'publish' => 0, 'alanguage' => config('app.locale')])->with('listAttr')->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        return view('product.frontend.search.index', compact('fcSystem', 'seo', 'data',  'attributes', 'brandFilter'));
    }
    public function product_filter(Request $request)
    {
        $data =  Product::select('category_products.title as titleC', 'category_products.slug as slugC', 'products.id', 'products.title', 'products.slug', 'products.price', 'products.price_sale', 'products.price_contact', 'products.image')
            ->where(['products.alanguage' => config('app.locale'), 'products.publish' => 0]);
        $keyword = $request->keyword;
        $perpage = $request->perpage;
        $onSaleProduct = $request->onSaleProduct;
        $brand = $request->brand;
        $request_attr = $request->attr;
        $sort = $request->sort;
        $data = $data->join('category_products', 'category_products.id', '=', 'products.catalogue_id');
        if (!empty($keyword)) {
            $data =  $data->where('products.title', 'like', '%' . $keyword . '%');
        }
        //xử lý danh mục
        $data = $data->join('catalogues_relationships', 'products.id', '=', 'catalogues_relationships.moduleid')
            ->where('catalogues_relationships.module', '=', 'products');
        if (!empty($request->catalogueid)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $request->catalogueid);
        }
        //xử lý brand
        if (!empty($onSaleProduct)) {
            $data =  $data->where('products.price_sale', '!=', 0);
        }

        if (!empty($brand)) {
            $data = $data->join('brands_relationships', 'products.id', '=', 'brands_relationships.product_id');
            $data =  $data->whereIn('brands_relationships.brand_id', $brand);
        }
        //xử lý khoảng giá
        $start_price = !empty($request->start_price) ? str_replace('.', '', $request->start_price) : 0;
        $end_price = !empty($request->end_price) ? str_replace('.', '', $request->end_price) : 0;
        if (isset($start_price) && !empty($end_price)) {
            $data =  $data->where('products.price', '>=', $start_price);
            $data =  $data->where('products.price', '<=', $end_price);
        }
        //xử lý thuộc tính
        if (!empty($request_attr)) {
            $attr = explode(';', $request_attr);
            foreach ($attr as $key => $val) {
                if ($key % 2 == 0) {
                    if ($val != '') {
                        $attribute[$val][] = $attr[$key + 1];
                    }
                } else {
                    continue;
                }
            }


            $total = 0;
            $index = 100;
            foreach ($attribute as $key => $val) {
                $total++;
                $index++;
                foreach ($val as $subs) {
                    $index = $index + $total;
                    $data = $data->join('attributes_relationships as tb' . $index . '', 'products.id', '=', 'tb' . $index . '.product_id');
                }
                $data =  $data->whereIn('tb' . $index . '.attribute_id', $val);
            }
            $data =  $data->groupBy('tb102.product_id');
        }

        $data =  $data->groupBy('catalogues_relationships.moduleid');
        //sort
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (count($sort) == 2) {
                $data =  $data->orderBy('products.' . $sort[0], $sort[1]);
            }
        } else {
            $data =  $data->orderBy('products.id', 'desc');
        }
        if (!empty($perpage)) {
            $data =  $data->paginate($perpage);
        } else {
            $data =  $data->paginate($this->paginate);
        }
        //render HTML
        $html = '';
        $paginate = '';
        if (!empty($request->js_typeHTML == 'col')) {
            foreach ($data as $k => $item) {
                $html .= '<div class="col-6 col-lg-3">' . htmlItemProduct2($k, $item) . '</div>';
            }
        } else {
            foreach ($data as $k => $item) {
                $html .= '<div class="col-12 col-lg-6">' . htmlItemProductList($k, $item) . '</div>';
            }
        }

        $paginator = $data;
        $interval = 2;
        $paginate .= view('homepage.common.pagination', compact('paginator', 'interval'))->render();
        echo json_encode(['html' => $html, 'paginate' => $paginate, 'total' => $data->total()]);
        die;
    }
    public function autocomplete(Request $request)
    {
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  Product::select('products.slug', 'products.title', 'products.image', 'products.code', 'products.price', 'products.price_sale', 'products.price_contact')->where(['alanguage' => config('app.locale'), 'publish' => 0]);
            $data = $data->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('code', 'like', '%' . $keyword . '%');
            });
            $data =  $data->orderBy('id', 'desc');
            $count =  $data->count();
            $data =  $data->limit(4)->get();
        } else {
            $data = [];
        }
        $html = '';
        if (!empty($data)) {
            foreach ($data as $item) {
                $price = getPrice(array('price' => $item['price'], 'price_sale' => $item['price_sale'], 'price_contact' =>
                $item['price_contact']));
                $route = route('routerURL', ['slug' => $item['slug']]);
                if (svl_ismobile() == 'is mobile') {
                    $html .= '<div class="ps-search__item">
                <div class="ps-product ps-product--horizontal">
                    <div class="ps-product__thumbnail">
                                                        <a class="ps-product__image" href="' . $route . '">
                                                            <figure><img src="' . asset($item['image']) . '" alt="' . $item['title'] . '" /></figure>
                        </a>

                    </div>
                    <div class="ps-product__content">
                                                        <h5 class="ps-product__title"><a href="' . $route . '">' . $item['title'] . '</a></h5>
                                                        <div class="ps-product__meta"><span class="ps-product__price">' . $price['price_final'] . '</span><span class="ps-product__del">' . $price['price_old'] . '</span>
                        </div>
                    </div>
                </div>
            </div>';
                } else {
                    $html .= '<div class="col-12 col-lg-6">
                                                <div class="ps-product ps-product--horizontal">
                                                    <div class="ps-product__thumbnail">
                                                        <a class="ps-product__image" href="' . $route . '">
                                                            <figure><img src="' . asset($item['image']) . '" alt="' . $item['title'] . '" /></figure>
                                                        </a>
                                                    </div>
                                                    <div class="ps-product__content">
                                                        <h5 class="ps-product__title"><a href="' . $route . '">' . $item['title'] . '</a></h5>
                                                        <div class="ps-product__meta"><span class="ps-product__price">' . $price['price_final'] . '</span><span class="ps-product__del">' . $price['price_old'] . '</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>';
                }
            }
        }
        $dataCount = !empty($count - 4 < 0)  ? 0 : $count - 4;
        return response()->json(['html' => $html, 'count' => $dataCount]);
    }
    public function autocompleteOnline(Request $request)
    {
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  Product::select('products.id', 'products.title', 'products.image')->where(['alanguage' => config('app.locale'), 'publish' => 0]);
            $data = $data->where(function ($query) use ($keyword) {
                $query->where('title', 'like', '%' . $keyword . '%')
                    ->orWhere('code', 'like', '%' . $keyword . '%');
            });
            $data =  $data->orderBy('order', 'asc');
            $data =  $data->orderBy('id', 'desc');
            $data =  $data->limit(20)->get();
        } else {
            $data = [];
        }
        $html = '';
        if (!empty($data)) {
            foreach ($data as $item) {
                $html .= '<div class="item">
                            <div class="img">
                                <img src="' . asset($item->image) . '" alt="' . $item->title . '">
                            </div>
                            <div class="nav-img">
                                <h3 class="title-3">' . $item->title . '</h3>
                            </div>
                            <div class="add">
                                <button class="js_handleAddProduct" data-id="' . $item->id . '" data-image="' .  asset($item->image) . '" data-title="' . $item->title . '">Thêm</button>
                            </div>
                        </div>';
            }
        }
        return response()->json(['html' => $html]);
    }
}
