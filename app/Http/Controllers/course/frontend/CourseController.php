<?php

namespace App\Http\Controllers\course\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request, $slug = "", $id = 0)
    {
        // Session::forget('cart');
        $segments = request()->segments();
        $slug = end($segments);
        $detail = Course::where(['alanguage' => config('app.locale'), 'slug' => $slug, 'publish' => 0])
            ->with(['fields', 'course_lessons', 'course_chapters'])
            ->first();
        $fields = [];
        if (!empty($detail->fields) && count($detail->fields) > 0) {
            foreach ($detail->fields as $item) {
                $fields[$item->meta_key] = !empty($item->meta_value) ? $item->meta_value : [];
            }
        }
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        //lấy danh mục cha
        $detailCatalogue = $detail->catalogues;
        //breadcrumb
        $breadcrumb = [];
        if (!empty($detailCatalogue)) {
            $breadcrumb = CourseCategory::select('title', 'slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detailCatalogue->lft)->where('rgt', '>=', $detailCatalogue->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        }
        //sản phẩm liên quan
        $same =  Course::join('catalogues_relationships', 'courses.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', 'courses');
        $same =  $same->where('catalogues_relationships.catalogueid', $detailCatalogue->id)->where('courses.id', '!=', $detail->id);
        $same =  $same->orderBy('courses.order', 'asc')->orderBy('courses.id', 'desc');
        $same =  $same->select('courses.id', 'courses.title', 'courses.image', 'courses.slug', 'courses.price', 'courses.price_sale', 'courses.price_contact');
        $same =  $same->limit(20);
        $same =  $same->get();
        $seo['canonical'] =  $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        $polylang = langURLFrontend('courses', config('app.locale'), $detail->id, '\App\Models\Course');
        if (!empty($polylang)) {
            foreach ($polylang as $key => $item) {
                $fcSystem['language_' . $key] = $item;
            }
        }
        return view('course.frontend.course.index', compact('fcSystem',  'detail', 'seo', 'same', 'detailCatalogue', 'fields', 'breadcrumb'));
    }
}
