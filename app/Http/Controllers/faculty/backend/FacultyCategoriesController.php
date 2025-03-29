<?php

namespace App\Http\Controllers\faculty\backend;

use App\Components\Nestedsetbie;
use App\Components\Polylang;
use App\Http\Controllers\Controller;
use App\Models\FacultyCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class FacultyCategoriesController extends Controller
{
    protected $nestedsetbie;
    protected $Polylang;
    protected $table = 'faculty_categories';
    public function __construct()
    {
        $this->nestedsetbie = new Nestedsetbie(array('table' => $this->table));
        $this->Polylang = new Polylang();
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {

        $data =  FacultyCategory::where('alanguage', config('app.locale'))->with('user')->with('faculties')->orderBy('lft', 'ASC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('faculty.backend.category.index', compact('data'));
    }


    public function create()
    {
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        return view('faculty.backend.category.create', compact('htmlCatalogue'));
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
            $image_url = uploadImageNone($request->file('image'), 'faculty-categories');
        } else {
            $image_url = $request->image_old;
        }

        $arrayImg = [
            'image_url' => $image_url,
        ];
        //end
        $this->submit($request, 'create', 0, $arrayImg);
        return redirect()->route('faculty_categories.index')->with('success', "Thêm mới nhóm phòng ban thành công");
    }

    public function edit($id)
    {
        $detail  = FacultyCategory::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('faculty_categories.index')->with('error', "nhóm phòng ban không tồn tại");
        }
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        return view('faculty.backend.category.edit', compact('detail', 'htmlCatalogue'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => ['required', Rule::unique('faculty_categories')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id)->where('alanguage', config('app.locale'));
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

        $arrayImg = [
            'image_url' => $image_url,
        ];
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('faculty_categories.index')->with('success', "Cập nhập nhóm phòng ban thành công");
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
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = FacultyCategory::insertGetId($_data);
        } else {
            FacultyCategory::find($id)->update($_data);
        }
        if (!empty($id)) {
            $this->nestedsetbie->Get();
            $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
            $this->nestedsetbie->Action();
        }
    }
}
