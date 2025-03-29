<?php

namespace App\Http\Controllers\course\backend;

use App\Components\Nestedsetbie;
use App\Components\Polylang;
use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class CourseCategoryController extends Controller
{
    protected $nestedsetbie;
    protected $Polylang;
    protected $table = 'course_categories';
    public function __construct()
    {
        $this->nestedsetbie = new Nestedsetbie(array('table' => $this->table));
        $this->Polylang = new Polylang();
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {

        $data =  CourseCategory::where('alanguage', config('app.locale'))->with('user')->with('courses')->orderBy('lft', 'ASC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('course.backend.category.index', compact('data', 'configIs'));
    }


    public function create()
    {
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $this->table])->get();
        return view('course.backend.category.create', compact('htmlCatalogue', 'field'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image,banner,...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'course-categories');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'course-categories');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'create', 0, $arrayImg);
        return redirect()->route('course_categories.index')->with('success', "Thêm mới nhóm đề thi thành công");
    }

    public function edit($id)
    {
        $detail  = CourseCategory::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('course_categories.index')->with('error', "Nhóm đề thi không tồn tại");
        }
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $this->table])->get();
        return view('course.backend.category.edit', compact('detail', 'htmlCatalogue', 'field'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid,alanguage,' . config('app.locale') . '',
            'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
                return $query->where('moduleid', '!=', $id)->where('alanguage', config('app.locale'));
            })],
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
        ]);
        //upload image,banner...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'quiz-categories');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'quiz-categories');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('course_categories.index')->with('success', "Cập nhập nhóm đề thi thành công");
    }

    public function submit($request = [], $action = '', $id = 0, $arrayImg = [])
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        $_data = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'description' => $request['description'],
            'parentid' => !empty($request['parentid']) ? $request['parentid'] : 0,
            'image' =>  !empty($arrayImg['image_url']) ? $arrayImg['image_url'] : '',
            'banner' =>  !empty($arrayImg['banner_url']) ? $arrayImg['banner_url'] : '',
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = CourseCategory::insertGetId($_data);
        } else {
            CourseCategory::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa bảng router
                DB::table('router')->where('moduleid', $id)->where('module', $this->table)->delete();
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
                $this->Polylang->insert($this->table, $request['language'], $id);
            }
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
            $this->nestedsetbie->Get();
            $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
            $this->nestedsetbie->Action();
        }
    }
}
