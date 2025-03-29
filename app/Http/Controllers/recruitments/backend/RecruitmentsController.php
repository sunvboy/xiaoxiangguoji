<?php

namespace App\Http\Controllers\recruitments\backend;

use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class RecruitmentsController extends Controller
{
    protected $table = 'recruitments';
    public function __construct()
    {
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data = Recruitment::orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('recruitments.backend.index', compact('data', 'configIs'));
    }
    public function create()
    {
        $action = 'create';
        return view('recruitments.backend.create', compact('action'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => ['required', Rule::unique('recruitments')],
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
        ]);
        $validator->validate();
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('recruitments.index')->with('success', "Thêm mới tuyển dụng thành công");
    }
    public function edit($id)
    {
        $detail  = Recruitment::find($id);
        if (!isset($detail)) {
            return redirect()->route('recruitments.index')->with('error', "Tuyển dụng không tồn tại");
        }
        $action = 'update';
        return view('recruitments.backend.create', compact('action', 'detail'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => ['required', Rule::unique('recruitments')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })],
        ], [
            'title.required' => 'Tên tag là trường bắt buộc.',
            'slug.required' => 'Đường dẫn bài viết là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn bài viết đã tồn tại.',
        ]);
        $validator->validate();
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), $this->table);
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('recruitments.index')->with('success', "Cập nhập tuyển dụng thành công");
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
            'date' => $request['date'],
            'nganh_nghe' => $request['nganh_nghe'],
            'so_luong' => $request['so_luong'],
            'noi_lam_viec' => $request['noi_lam_viec'],
            'muc_luong' => $request['muc_luong'],
            'hinh_thuc_lam_viec' => $request['hinh_thuc_lam_viec'],
            'so_nam_kinh_nghiem' => $request['so_nam_kinh_nghiem'],
            'hinh_thuc_lam_viec' => $request['hinh_thuc_lam_viec'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'content' => $request['content'],
            'image' => $image_url,
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = Recruitment::insertGetId($_data);
        } else {
            Recruitment::find($id)->update($_data);
        }
    }
}
