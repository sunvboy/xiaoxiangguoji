<?php

namespace App\Http\Controllers\homepage;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Components\Comment;
use App\Components\System;
use App\Components\Nestedsetbie;
use App\Components\Helper;
use App\Models\Faq;
use App\Models\Media;
use App\Models\Team;
use Image;

class HomeController extends Controller
{
    protected $comment;
    protected $system;
    protected $Nestedsetbie;
    protected $Helper;

    public function __construct()
    {
        $this->comment = new Comment();
        $this->system = new System();
        $this->Helper = new Helper();
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'category_products'));
    }
    public function index()
    {
        $fcSystem = $this->system->fcSystem();
        $slideHome = \App\Models\CategorySlide::select('title', 'id')->where(['alanguage' => config('app.locale'), 'keyword' => 'bannerHome'])->with('slides')->first();
        $features = \App\Models\CategorySlide::select('title', 'id')->where(['alanguage' => config('app.locale'), 'keyword' => 'features'])->with('slides')->first();

        $services =
            \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'id' => 9])
            ->with(['posts' => function ($query) {
                $query->limit(6)->get();
            }])
            ->first();
        $serviceLists =
            \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'id' => 9])
            ->with(['posts'])
            ->first();
        $projects =
            \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'id' => 10])
            ->with(['posts' => function ($query) {
                $query->limit(6)->get();
            }])
            ->first();
        $teams =
            \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'id' => 11])
            ->with(['posts'])
            ->first();
        $testimonials =
            \App\Models\CategoryArticle::select('id', 'title', 'slug', 'description')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'id' => 12])
            ->with(['posts'])
            ->first();
        $page = Page::with('fields')->where(['alanguage' => config('app.locale'), 'page' => 'index', 'publish' => 0])->select('id', 'title', 'image', 'meta_title', 'meta_description')->first();
        $fields = [];
        if (!empty($page->fields) && count($page->fields) > 0) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? $item->meta_value : '';
            }
        }
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $module = 'home';
        $images = Media::where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 1])->first();
        return view('homepage.home.index', compact('module', 'page', 'seo', 'fcSystem', 'fields', 'slideHome', 'features', 'services', 'projects', 'serviceLists', 'teams', 'testimonials'));
    }
    public function search(Request $request)
    {

        $fcSystem = $this->system->fcSystem();
        $page = Page::with('fields')->where(['alanguage' => config('app.locale'), 'page' => 'index', 'publish' => 0])->select('id', 'title', 'image', 'meta_title', 'meta_description')->first();
        $keyword = $request->keyword;
        $data = [];
        if (!empty($keyword)) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://viporder.com.vn/api/v1/warehouses-search?keyword=' . $keyword,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $data = json_decode($response, TRUE);
        }
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        return view('homepage.home.search', compact('page', 'seo', 'fcSystem', 'data'));
    }
    public function system()
    {
        $fcSystem = $this->system->fcSystem();
        $seo['canonical'] = url('/');
        $seo['meta_title'] = 'Hệ thống';
        $seo['meta_description'] = 'Hệ thống';
        $seo['meta_image'] = '';
        return view('homepage.home.html.page', compact('fcSystem'));
    }



    public function sitemap()
    {
        /*
        $Tags = \App\Models\Tag::select('id', 'slug', 'created_at')->where('alanguage', config('app.locale'))->where('publish', 0)->get();
        $Brands = \App\Models\Brand::select('id', 'slug', 'created_at')->where('alanguage', config('app.locale'))->where('publish', 0)->get(); */
        $router = DB::table('router')->select('slug', 'created_at')->get();
        return response()->view('homepage.home.sitemap', compact('router'))->header('Content-Type', 'text/xml');
    }
    public function wishlist_index()
    {
        $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;

        if (!empty($wishlist)) {
            $data = \App\Models\Product::select('products.id', 'products.title', 'products.image_json', 'products.image', 'products.slug', 'products.price', 'products.price_sale', 'products.price_contact')
                ->where(['products.alanguage' => config('app.locale'), 'products.publish' => 0])
                ->whereIn('products.id', $wishlist)
                ->orderBy('products.order', 'asc')
                ->orderBy('products.id', 'desc')
                ->with('getTags')
                ->get();
        } else {
            $data = [];
        }


        $fcSystem = $this->system->fcSystem();
        $seo['canonical'] = route('homepage.wishlist_index');
        $seo['meta_title'] = "Danh sách sản phẩm yêu thích";
        $seo['meta_description'] = "Danh sách sản phẩm yêu thích";
        return view('homepage.home.wishlist', compact('seo', 'fcSystem', 'data'));
    }
    public function wishlist(Request $request)
    {
        $wishlist = isset($_COOKIE['wishlist']) ? json_decode($_COOKIE['wishlist'], TRUE) : NULL;
        $quantity = $wishlist ? count($wishlist) : 0;
        $productID = $request->id;
        if (!empty($wishlist)) {
            if (in_array($request->id, $wishlist)) {
                $filtered = collect($wishlist)->filter(function ($value, $key) use ($productID) {
                    return $value != $productID;
                });
                $quantity--;
                setcookie('wishlist', json_encode($filtered), time() + (86400 * 30), '/');
                return response()->json(['message' => 'Xóa sản phẩm khỏi Danh sách sản phẩm yêu thích thành công', 'status' => 400, 'quantity' => $quantity]);
            } else {
                $cookie = collect($wishlist)->push($request->id)->all();
                $quantity++;
                setcookie('wishlist', json_encode($cookie), time() + (86400 * 30), '/');
                return response()->json(['message' => 'Thêm sản phẩm vào Danh sách sản phẩm yêu thích thành công', 'status' => 200, 'quantity' => $quantity]);
            }
        } else {
            $quantity++;
            setcookie('wishlist', json_encode(array($request->id)), time() + (86400 * 30), '/');
            return response()->json(['message' => 'Thêm sản phẩm vào Danh sách sản phẩm yêu thích thành công', 'status' => 200, 'quantity' => $quantity]);
        }
    }
    //dropzone upload
    public function dropzone_upload(Request $request)
    {
        $image_url = '';
        $image = $request->file('file');
        if (!empty($image)) {
            $name_gen = hexdec(uniqid()) . '.webp';
            $base_path = base_path('upload/images/album-anh-dat-thuoc-online');
            if (!file_exists($base_path)) {
                mkdir($base_path, 0777, true);
            }
            Image::make($image)->encode('webp', 100)->save($base_path . '/' . $name_gen);
            $image_url = 'upload/images/album-anh-dat-thuoc-online/' . $name_gen;
        }
        echo $image_url;
        die;
    }
}
