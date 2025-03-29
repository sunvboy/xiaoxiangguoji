<?php

namespace App\Http\Controllers\faculty\backend;

use App\Components\Helper;
use App\Components\Nestedsetbie;
use App\Components\Polylang;
use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class FacultiesController extends Controller
{
    protected $Nestedsetbie;
    protected $Helper;
    protected $Polylang;
    protected $table = 'faculties';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'faculty_categories'));
        $this->Helper = new Helper();
        $this->Polylang = new Polylang();
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  Faculty::where(['alanguage' => config('app.locale')])
            ->with('user:id,name')
            ->with('faculty_categories:id,title')
            ->orderBy('order', 'ASC')
            ->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $catalogueid = $request->catalogueid;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.title', 'like', '%' . $keyword . '%');
        }
        if (!empty($catalogueid)) {
            $data =  $data->where('faculty_category_id', $catalogueid);
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($catalogueid)) {
            $data->appends(['catalogueid' => $catalogueid]);
        }
        $htmlOption = $this->Nestedsetbie->dropdown([], config('app.locale'));
        return view('faculty.backend.faculty.index', compact('data', 'htmlOption'));
    }
    public function create()
    {
        $dropdown = getFunctions();
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        return view('faculty.backend.faculty.create', compact('htmlCatalogue',  'dropdown'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'slug' =>  ['required', Rule::unique('faculties')->where(function ($query) use ($request) {
                return $query->where('alanguage', config('app.locale'));
            })],
            'faculty_category_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn phòng ban là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn phòng ban đã tồn tại.',
            'faculty_category_id.gt' => 'Danh mục là trường bắt buộc.',
        ]);
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'faculties');
        } else {
            $image_url = $request->image_old;
        }
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('faculties.index')->with('success', "Thêm mới phòng ban thành công");
    }
    public function edit($id)
    {
        $dropdown = getFunctions();
        $module = $this->table;
        $detail  = Faculty::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('faculties.index')->with('error', "Bài viết không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $getCatalogue = [];
        $getProduct = [];
        if (old('catalogue')) {
            $getCatalogue = old('catalogue');
        } else {
            $getCatalogue = json_decode($detail->catalogue);
        }

        return view('faculty.backend.faculty.edit', compact('module', 'detail', 'htmlCatalogue',  'dropdown',  'getCatalogue'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'slug' => ['required', Rule::unique('faculties')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id)->where('alanguage', config('app.locale'));
            })],
            'faculty_category_id' => 'required|gt:0',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
            'faculty_category_id.gt' => 'Danh mục chính là trường bắt buộc.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'faculties');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('faculties.index')->with('success', "Cập nhập phòng ban thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $image_url = '')
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        $_data = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'code' => $request['code'],
            'faculty_category_id' => $request['faculty_category_id'],
            'image' => !empty($image_url) ? $image_url : '',
            'description' => $request['description'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = Faculty::insertGetId($_data);
        } else {
            Faculty::find($id)->update($_data);
        }
    }
}
