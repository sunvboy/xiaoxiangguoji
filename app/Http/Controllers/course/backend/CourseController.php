<?php

namespace App\Http\Controllers\course\backend;

use App\Components\Helper;
use App\Components\Nestedsetbie;
use App\Components\Polylang;
use App\Http\Controllers\Controller;
use App\Models\CoursAttributesRelationships;
use App\Models\Course;
use App\Models\CourseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    protected $Nestedsetbie;
    protected $Helper;
    protected $Polylang;
    protected $table = 'courses';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'course_categories'));
        $this->Helper = new Helper();
        $this->Polylang = new Polylang();
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  Course::where(['alanguage' => config('app.locale')])
            ->with('user:id,name')
            ->with(['relationships' => function ($query) {
                $query->select('catalogues_relationships.moduleid', 'course_categories.title', 'course_categories.id')
                    ->where('module', '=', $this->table)
                    ->join('course_categories', 'course_categories.id', '=', 'catalogues_relationships.catalogueid');
            }])
            ->orderBy('order', 'ASC')
            ->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $catalogueid = $request->catalogueid;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        if (!empty($type)) {
            $data =  $data->where($this->table . '.' . $type,  1);
        }
        $data = $data->join('catalogues_relationships', $this->table . '.id', '=', 'catalogues_relationships.moduleid')->where('catalogues_relationships.module', '=', $this->table);
        if (!empty($catalogueid)) {
            $data =  $data->where('catalogues_relationships.catalogueid', $catalogueid);
        }
        $data =  $data->select('courses.id', 'courses.image', 'courses.title', 'courses.slug', 'courses.course_category_id', 'courses.user_id', 'courses.created_at', 'courses.publish', 'courses.order', 'courses.ishome', 'courses.highlight', 'courses.isaside', 'courses.isfooter');
        $data =  $data->groupBy('catalogues_relationships.moduleid');
        $data =  $data->paginate(env('APP_paginate'));
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($catalogueid)) {
            $data->appends(['catalogueid' => $catalogueid]);
        }
        $htmlOption = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('course.backend.course.index', compact('data', 'htmlOption', 'configIs'));
    }
    public function create()
    {
        $dropdown = getFunctions();
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $this->table])->get();
        //attribute
        if (old('attribute')) {
            $attribute = old('attribute');
        }
        $category_attribute = DB::table('category_attributes')
            ->select('id', 'title')
            ->where('alanguage', config('app.locale'))
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        $attribute_json = [];
        if (!empty($attribute)) {
            foreach ($attribute as $key => $value) {
                if ($value == '') {
                    $attribute_json[$key] = '';
                } else {
                    // $attribute_json[$key]['json'] = base64_encode(json_encode($value));
                    $attributes =  DB::table('attributes')->orderBy('order', 'asc')->orderBy('id', 'desc')->whereIn('id', $value)->get();
                    $temp = [];
                    if (!empty($attributes)) {
                        foreach ($attributes as $val) {
                            $temp[] = array(
                                'id' => $val->id,
                                'text' => $val->title,
                            );
                        }
                    }
                    $attribute_json[$key] = $temp;
                }
            }
        }
        $htmlAttribute = $this->Nestedsetbie->DropdownCatalogue($category_attribute, 'Chọn danh mục thuộc tính');
        return view('course.backend.course.create', compact('htmlCatalogue', 'field', 'dropdown', 'htmlAttribute', 'attribute_json'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . config('app.locale') . ',alanguage',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
            'course_category_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn khóa học là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn khóa học đã tồn tại.',
            'course_category_id.gt' => 'Danh mục là trường bắt buộc.',
        ]);
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'courses');
        } else {
            $image_url = $request->image_old;
        }
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('courses.index')->with('success', "Thêm mới khóa học thành công");
    }
    public function edit($id)
    {
        $dropdown = getFunctions();
        $module = $this->table;
        $detail  = Course::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('courses.index')->with('error', "Bài viết không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $getCatalogue = [];
        $getProduct = [];
        if (old('catalogue')) {
            $getCatalogue = old('catalogue');
        } else {
            $getCatalogue = json_decode($detail->catalogue);
        }
        //attr
        $category_attribute = DB::table('category_attributes')
            ->select('id', 'title')
            ->where('alanguage', config('app.locale'))
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->get();
        $htmlAttribute = $this->Nestedsetbie->DropdownCatalogue($category_attribute);
        if (old('attribute')) {
            $attribute = old('attribute');
        } else {
            $version_json = json_decode(base64_decode($detail->version_json), true);
            $attribute = $version_json[2];
        }
        $attribute_json = [];
        if (!empty($attribute)) {
            foreach ($attribute as $key => $value) {
                if ($value == '') {
                    $attribute_json[$key] = '';
                } else {
                    // $attribute_json[$key]['json'] = base64_encode(json_encode($value));
                    $attributes =  DB::table('attributes')->orderBy('order', 'asc')->orderBy('id', 'desc')->whereIn('id', $value)->get();
                    $temp = [];
                    if (!empty($attributes)) {
                        foreach ($attributes as $val) {
                            $temp[] = array(
                                'id' => $val->id,
                                'text' => $val->title,
                            );
                        }
                    }
                    $attribute_json[$key] = $temp;
                }
            }
        }
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('course.backend.course.edit', compact('module', 'detail', 'htmlCatalogue',  'dropdown',  'getCatalogue', 'field', 'htmlAttribute', 'attribute_json'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid', '!=', $id)->where('alanguage', config('app.locale'));
            })],
            'course_category_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'course_category_id.gt' => 'Danh mục chính là trường bắt buộc.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'courses');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('courses.index')->with('success', "Cập nhập khóa học thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $image_url = '')
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        //danh mục phụ
        $catalogue = $request['catalogue'];
        $tmp_catalogue[] = (int)$request['course_category_id'];
        if (isset($catalogue)) {
            foreach ($catalogue as $v) {
                if ($v != 0 && $v != $request['course_category_id']) {
                    $tmp_catalogue[] = (int)$v;
                }
            }
        }
        //lấy danh mục cha (nếu có)
        $detail = CourseCategory::select('id', 'title', 'slug', 'lft')->where('id', $request['course_category_id'])->first();
        $breadcrumb = CourseCategory::select('id', 'title')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        if ($breadcrumb->count() > 0) {
            foreach ($breadcrumb as $v) {
                $tmp_catalogue[] = $v->id;
            }
        }
        $tmp_catalogue = array_unique($tmp_catalogue);
        //end
        //version
        $checkbox = isset($request['checkbox_val']) ? $request['checkbox_val'] : [];
        $attribute_catalogue = isset($request['attribute_catalogue']) ? $request['attribute_catalogue'] : [];
        $attribute = isset($request['attribute']) ? $request['attribute'] : [];

        $_data = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'code' => $request['code'],
            'course_category_id' => $request['course_category_id'],
            'image' => !empty($image_url) ? $image_url : '',
            'description' => $request['description'],
            'catalogue' => json_encode($tmp_catalogue),
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
            'price' => isset($request['price']) ? str_replace('.', '', $request['price']) : 0,
            'price_sale' => isset($request['price_sale']) ? str_replace('.', '', $request['price_sale']) : 0,
            'price_contact' => isset($request['price_contact']) ? $request['price_contact'] : 0,
            'version_json' => base64_encode(json_encode(array($checkbox, $attribute_catalogue, $attribute))),
        ];
        if ($action == 'create') {
            $id = Course::insertGetId($_data);
        } else {
            Course::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa bảng router
                DB::table('router')->where(['moduleid' => $id, 'module' => $this->table])->delete();
                //xóa catalogue_relationship
                DB::table('catalogues_relationships')->where(['moduleid' => $id, 'module' => $this->table])->delete();
                /*xóa attribute_relationship*/
                CoursAttributesRelationships::where('course_id', $id)->delete();
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
                $this->Polylang->insert($this->table, $request['language'], $id);
            }
            //thêm vào bảng catalogue_relationship
            $this->Helper->catalogue_relation_ship($id, $request['course_category_id'], $tmp_catalogue, $this->table);
            //thêm tag
            $this->Helper->tags_relationships($id, $request['tags'], $this->table);
            //thêm router
            DB::table('router')->insert([
                'moduleid' => $id,
                'module' => $this->table,
                'slug' => $request['slug'],
                'created_at' => Carbon::now(),
                'alanguage' => config('app.locale'),
            ]);
            //START: custom fields
            fieldsInsert($this->table, $id, $request);
            //END
            //START: Course
            $this->Helper->addCourse($request['chapter'], $request['lesson'], $id, $action);
            //END: Course
            $this->Helper->cours_attributes_relationships($id, $attribute, $tmp_catalogue);
        }
    }
}
