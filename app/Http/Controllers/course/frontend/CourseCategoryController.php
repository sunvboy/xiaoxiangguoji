<?php

namespace App\Http\Controllers\course\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseCategoryController extends Controller
{
    protected $paginate = 18;
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index($slug = "", Request $request)
    {
        $segments = request()->segments();
        $slug = end($segments);
        $detail = CourseCategory::select('id', 'slug', 'title', 'description', 'meta_description', 'meta_title', 'publish', 'lft', 'image', 'banner', 'ishome', 'highlight', 'isaside', 'isfooter', 'parentid')
            ->where('alanguage', config('app.locale'))
            ->where('publish', 0)
            ->where('slug', $slug)
            ->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $data =  Course::join('catalogues_relationships', 'courses.id', '=', 'catalogues_relationships.moduleid')
            ->where('catalogues_relationships.module', '=', 'courses')
            ->with(['field' => function ($q) {
                $q->select('module_id', 'meta_value')->where('meta_key', 'config_colums_input_duration');
            }])
            ->with(['course_lessons'])
            ->select('courses.course_category_id', 'courses.catalogue', 'courses.id', 'courses.title', 'courses.slug', 'courses.image', 'courses.price', 'courses.price_sale', 'courses.price_contact');
        if (!empty($detail->id)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $detail->id);
        }
        $data =  $data->orderBy('courses.price', 'desc')->orderBy('courses.price_sale', 'desc')->orderBy('courses.id', 'desc');
        $data =  $data->paginate($this->paginate);
        // breadcrumb
        $breadcrumb = CourseCategory::select('title', 'slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        $seo['canonical'] = route('routerURL', ['slug' => $slug]);
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        $polylang = langURLFrontend('course_categories', config('app.locale'), $detail->id, '\App\Models\CourseCategory');
        if (!empty($polylang)) {
            foreach ($polylang as $key => $item) {
                $fcSystem['language_' . $key] = $item;
            }
        }
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
        return view('course.frontend.category.index', compact('fcSystem', 'detail', 'seo', 'data', 'breadcrumb', 'attributes'));
    }
    public function filter(Request $request)
    {
        // DB::enableQueryLog();
        $data =  Course::select('courses.catalogue', 'courses.id', 'courses.title', 'courses.slug', 'courses.price', 'courses.price_sale', 'courses.price_contact', 'courses.image')
            ->where(['courses.alanguage' => config('app.locale'), 'courses.publish' => 0]);
        $data = $data->join('course_categories', 'course_categories.id', '=', 'courses.course_category_id');
        $request_attr = $request->attr;
        //xử lý danh mục
        $data = $data->join('catalogues_relationships', 'courses.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', 'courses');
        if (!empty($request->catalogueid)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $request->catalogueid);
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
                    $data = $data->join('cours_attributes_relationships as tb' . $index . '', 'courses.id', '=', 'tb' . $index . '.course_id');
                }
                $data =  $data->whereIn('tb' . $index . '.attribute_id', $val);
            }
            $data =  $data->groupBy('tb102.course_id');
        }
        $data =  $data->groupBy('catalogues_relationships.moduleid');
        $data =  $data->orderBy('courses.id', 'desc');
        $data =  $data->paginate($this->paginate);
        //render HTML
        $html = '';
        $paginate = '';
        foreach ($data as $k => $item) {
            $html .= htmlItemCourse($item, '');
        }
        $paginate .= $data->links();
        return response()->json(['html' => $html, 'paginate' => $paginate]);
    }
}
