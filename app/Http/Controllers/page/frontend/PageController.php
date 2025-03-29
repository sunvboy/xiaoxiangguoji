<?php

namespace App\Http\Controllers\page\frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Components\System;
use App\Models\Address;
use App\Models\Article;
use App\Models\CategoryArticle;
use App\Models\Faq;
use App\Models\OrderOnline;
use App\Models\Orders_item;
use App\Models\Team;
use App\Models\VNCity;
use App\Rules\PhoneNumber;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Validator;
use Auth;

class PageController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function aboutUs()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'aboutus', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? $item->meta_value : '';
            }
        }
        // dd($fields);
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.aboutus', compact('seo', 'page', 'fcSystem', 'fields'));
    }
    public function order()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'order', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? json_decode($item->meta_value) : [];
            }
        }
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.order', compact('seo', 'page', 'fcSystem', 'fields'));
    }
    public function teams()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'teams', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? json_decode($item->meta_value) : [];
            }
        }
        $data =  Team::orderBy('order', 'asc')->orderBy('id', 'DESC');
        $data =  $data->paginate(18);
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.teams', compact('seo', 'page', 'fcSystem', 'fields', 'data'));
    }
    public function faqs()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'faqs', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? json_decode($item->meta_value) : [];
            }
        }
        $data =  Faq::orderBy('order', 'asc')->orderBy('id', 'DESC');
        $data =  $data->paginate(10);
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.faqs', compact('seo', 'page', 'fcSystem', 'fields', 'data'));
    }
    public function examination()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'examination', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? json_decode($item->meta_value) : [];
            }
        }
        $data =  Faq::orderBy('order', 'asc')->orderBy('id', 'DESC');
        $data =  $data->paginate(10);
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.examination', compact('seo', 'page', 'fcSystem', 'fields', 'data'));
    }
    public function test()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'test', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? json_decode($item->meta_value) : [];
            }
        }
        $data = \App\Models\Quiz::with(['quiz_questions'])->orderBy('order', 'asc')->orderBy('id', 'desc')->get();
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.test', compact('seo', 'page', 'fcSystem', 'fields', 'data'));
    }
    public function address()
    {
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'address', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? $item->meta_value : [];
            }
        }
        $address = Address::select('id', 'title', 'image', 'cityid')->get();
        $vn_province_id = $address->pluck('cityid');
        $vn_province = VNCity::whereIn('id', $vn_province_id)->get();

        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.address', compact('seo', 'page', 'fcSystem', 'fields', 'address', 'vn_province'));
    }
    public function addressDetail(Request $request)
    {
        $fcSystem = $this->system->fcSystem();

        $id = $request->id;
        $detail = Address::find($id);
        $html = '<div style="padding-bottom: 50px;">
                            <h3 class="css-e30d1v">' . $detail->title . '</h3>
                            <div class="row">
                                <div class="col-md-5">
                                ' . $detail->iframe . '
                                </div>
                                <div class="col-md-7">
                                    <p class="css-1oqd6bl text-gray-7">Địa chỉ:</p>
                                    <a class="css-1v577ri !text-gray-10 py-1 font-bold" target="_blank" href=" ' . $detail->link . '">' . $detail->address . '</a>
                                    <div class="store_close-time flex items-center py-1">
                                        <div class="mx-2 h-[4px] w-[4px] rounded-full bg-[var(--gray-500)]"></div>
                                        <p class="css-1oqd6bl text-gray-7">' . $detail->time . '</p>
                                    </div>
                                    <div class="store-phone flex py-1">
                                        <p class="css-1oqd6bl text-gray-7 mr-1">Điện thoại:</p><a class="css-1v577ri text-gray-10" href="tel:' . $detail->hotline . '">' . $detail->hotline . '.</a>
                                    </div>
                                    <div class="flex">
                                        <div class="css-1sdho3w">
                                            <div class="btn-map"><a target="_blank" href="https://maps.google.com/maps/place/21.152866,105.900074" class="css-1l7n2ui">Xem chỉ đường</a></div>
                                            <div class="btn-advise"><a class="css-1v577ri text-gray-10" href="tel:' . $detail->hotline . '">Gọi tư vấn</a></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        $albums = '';

        $albums .= '<h3 class="title-3">' . $fcSystem['title_12'] . '</h3>';
        $albums .= '<div class="slider-libary-album owl-carousel">';
        $albums .= '<div class="item">
                                        <img src="' . asset($detail->image) . '" alt="hình ảnh nhà thuốc">
                                    </div>';
        if (!empty($detail->image_json)) {
            $image_json = json_decode($detail->image_json, true);
            foreach ($image_json as $val) {
                if (!empty($val)) {
                    $albums .= '<div class="item">
                                        <img src="' . asset($val) . '" alt="hình ảnh nhà thuốc">
                                    </div>';
                }
            }
        }
        $albums .= '</div>';


        return response()->json(['html' => $html, 'albums' => $albums]);
    }
    public function addressGetLocation(Request $request)
    {
        $param = $request->param;
        $type = $param['type'];
        $table  = '';
        $textWard  = '';
        $temp = '';
        if ($type == 'city') {
            $table = 'vn_district';
            $where = ['ProvinceID' => $param['id']];
            $textWard  =  '<option value="">' . trans('index.Ward') . '</option>';
            $temp = $temp . '<option value="0">Chọn Quận/Huyện</option>';
        } else if ($type == 'district') {
            $table = 'vn_ward';
            $where = ['DistrictID' => $param['id']];
            $temp = $temp . '<option value="0">' . trans('index.Ward') . '</option>';
        }
        $getData = DB::table($table)->select('id', 'name')->where($where)->orderBy('name', 'asc')->get();
        if (isset($getData)) {
            foreach ($getData as  $val) {
                $temp = $temp . '<option value="' . $val->id . '">' . $val->name . '</option>';
            }
        }
        //lấy hình ảnh chi nhánh

        if ($type == 'city') {
            $detail = Address::where('cityid', $param['id'])->get();
        } else if ($type == 'district') {
            $detail = Address::where('districtid', $param['id'])->get();
        }
        $albums = $htmlItems = '';
        if (!empty($detail)) {
            $albums .= '<div class="slider-libary-album owl-carousel">';
            $htmlItems .= '<ul>';
            foreach ($detail as $val) {
                if (!empty($val->image)) {
                    $albums .= '<div class="item">
                                        <img src="' . asset($val->image) . '" alt="hình ảnh nhà thuốc">
                                    </div>';
                }
                $htmlItems .= ' <li>
                                <label style="cursor: pointer;">
                                    <input type="radio" value="' . $val->id . '" name="address_id">
                                    ' . $val->title . '
                                </label>
                            </li>';
            }
            $htmlItems .= '</ul>';
            $albums .= '</div>';
        }
        //end

        echo json_encode(array(
            'html' => $temp,
            'textWard' => $textWard,
            'albums' => $albums,
            'htmlItems' => $htmlItems
        ));
        die();
    }
    public function online()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'online', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $fields = [];
        if (!empty($page->fields)) {
            foreach ($page->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? json_decode($item->meta_value) : [];
            }
        }
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.online', compact('seo', 'page', 'fcSystem', 'fields'));
    }
    public function onlineStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'phone' => ['required', new PhoneNumber],
        ], [
            'name.required' => 'Trường Họ và tên là trường bắt buộc.',
            'phone.required' => 'Số điện thoại không được để trống.',
        ]);
        if ($validator->passes()) {
            $products = [];
            if (!empty($request->product_id)) {
                foreach ($request->product_id as $key => $item) {
                    $products[] = [
                        'id' => $item,
                        'title' => !empty($request->product_title[$key]) ? $request->product_title[$key] : null,
                        'image' => !empty($request->product_image[$key]) ? $request->product_image[$key] : null,
                        'quantity' => !empty($request->product_quantity[$key]) ? $request->product_quantity[$key] : null,
                    ];
                }
            }
            $id = OrderOnline::insertGetId([
                'name' => $request->name,
                'phone' => $request->phone,
                'message' => $request->message,
                'products' => !empty($products) ? json_encode($products) : null,
                'image_json' => !empty($request->album) ? json_encode($request->album) : null,
                'created_at' => Carbon::now(),
                'customer_id' => !empty(Auth::guard('customer')->user()) ? Auth::guard('customer')->user()->id : null
            ]);
            if ($id > 0) {
                return response()->json(['status' => '200']);
            } else {
                return response()->json(['status' => '500']);
            }
        }
        return response()->json(['error' => $validator->errors()->all()]);
    }
    public function category()
    {
        //page: HOME
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'category', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->first();
        $cothenguoi = CategoryArticle::where('id', 36)->with([
            'children' => function ($q) {
                $q->orderBy('order', 'asc')->orderBy('id', 'desc');
            }
        ])->first();
        $data = [];
        if (!empty($cothenguoi['children'])) {
            $data = \App\Models\Catalogues_relationships::select('articles.title', 'articles.id', 'articles.slug')->where(['catalogueid' => $cothenguoi['children'][0]->id, 'module' => 'articles', 'articles.publish' => 0])
                ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
                ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
                // ->with('tagsArticle')
                ->orderBy('articles.id', 'desc')
                ->paginate(20);
        }
        $doituong = CategoryArticle::where('id', 38)->with([
            'children' => function ($q) {
                $q->orderBy('order', 'asc')->orderBy('id', 'desc');
            }
        ])->first();
        $benhtheomua = CategoryArticle::where('id', 39)->first();
        $benhchuyenkhoa = CategoryArticle::where('id', 40)->with([
            'children' => function ($q) {
                $q->orderBy('order', 'asc')->orderBy('id', 'desc');
            }
        ])->first();
        $data2 = [];
        if (!empty($benhchuyenkhoa['children'])) {
            $data2 = \App\Models\Catalogues_relationships::select('articles.title', 'articles.id', 'articles.slug')->where(['catalogueid' => $benhchuyenkhoa['children'][0]->id, 'module' => 'articles', 'articles.publish' => 0])
                ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
                ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
                ->orderBy('articles.id', 'desc')
                ->paginate(21);
        }
        $seo['canonical'] = url('/');
        $seo['meta_title'] = !empty($page['meta_title']) ? $page['meta_title'] : $page['title'];
        $seo['meta_description'] = !empty($page['meta_description']) ? $page['meta_description'] : '';
        $seo['meta_image'] = !empty($page['image']) ? url($page['image']) : '';
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.category', compact('seo', 'page', 'fcSystem', 'cothenguoi', 'data', 'doituong', 'benhtheomua', 'benhchuyenkhoa', 'data2'));
    }
    public function categoryChild($id)
    {
        $detail = CategoryArticle::select('id', 'slug', 'title', 'description', 'meta_description', 'meta_title', 'publish', 'lft', 'image', 'banner', 'ishome', 'highlight', 'isaside', 'isfooter', 'parentid')
            ->where('alanguage', config('app.locale'))
            ->where('publish', 0)
            ->where('id', $id)
            ->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $data = \App\Models\Catalogues_relationships::select('articles.title', 'articles.id', 'articles.slug', 'articles.image', 'articles.description', 'articles.catalogue_id', 'category_articles.title as titleC', 'category_articles.slug as slugC')->where(['catalogueid' => $detail->id, 'module' => 'articles', 'articles.publish' => 0])
            ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
            // ->with('tagsArticle')
            ->orderBy('articles.id', 'desc')
            ->paginate(21);
        $seo['canonical'] = route('category.categoryChild', ['id' => $id]);
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('page.frontend.categoryChild', compact('seo', 'fcSystem', 'detail', 'data'));
    }
    public function cothenguoi(Request $request)
    {
        $html = '';
        $data = \App\Models\Catalogues_relationships::select('articles.title', 'articles.id', 'articles.slug')->where(['catalogueid' => $request->id, 'module' => 'articles', 'articles.publish' => 0])
            ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
            // ->with('tagsArticle')
            ->orderBy('articles.id', 'desc')
            ->paginate(20);
        if (!empty($data)) {
            foreach ($data as $item) {
                $html .= '<li><a href="' . route('routerURL', ['slug' => $item->slug]) . '">' . $item->title . '</a></li>';
            }
        }
        return response()->json(['html' => $html, 'paginate' => view('homepage.common.pagination', ['paginator' => $data, 'interval' => 2])->render()]);
    }
    public function benhchuyenkhoa(Request $request)
    {
        $html = '';
        $data = \App\Models\Catalogues_relationships::select('articles.title', 'articles.id', 'articles.slug')->where(['catalogueid' => $request->id, 'module' => 'articles', 'articles.publish' => 0])
            ->join('articles', 'articles.id', '=', 'catalogues_relationships.moduleid')
            ->join('category_articles', 'category_articles.id', '=', 'articles.catalogue_id')
            // ->with('tagsArticle')
            ->orderBy('articles.id', 'desc')
            ->paginate(21);
        if (!empty($data)) {
            foreach ($data as $item) {
                $html .= '<li><a href="' . route('routerURL', ['slug' => $item->slug]) . '">' . $item->title . '</a></li>';
            }
        }
        return response()->json(['html' => $html, 'paginate' => view('homepage.common.pagination', ['paginator' => $data, 'interval' => 2])->render()]);
    }
}
