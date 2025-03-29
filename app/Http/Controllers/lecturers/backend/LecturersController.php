<?php

namespace App\Http\Controllers\lecturers\backend;

use App\Http\Controllers\Controller;
use App\Models\Lecturers;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class LecturersController extends Controller
{
    protected $table = 'lecturers';
    public function __construct()
    {
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  Lecturers::orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('name', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('lecturers.backend.index', compact('data', 'configIs'));
    }
    public function create()
    {
        $action = 'create';
        return view('lecturers.backend.create', compact('action'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Tên giảng viên là trường bắt buộc.',
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
        return redirect()->route('lecturers.index')->with('success', "Thêm mới giảng viên thành công");
    }
    public function edit($id)
    {
        $detail  = Lecturers::find($id);
        if (!isset($detail)) {
            return redirect()->route('lecturers.index')->with('error', "Giảng viên không tồn tại");
        }
        $action = 'update';
        return view('lecturers.backend.create', compact('action', 'detail'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',

        ], [
            'name.required' => 'Tên giảng viên là trường bắt buộc.',
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
        return redirect()->route('lecturers.index')->with('success', "Cập nhập giảng viên thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $image_url = '')
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        $_data = [
            'name' => $request['name'],
            'image' => $image_url,
            'description' => $request['description'],
            'experience' => $request['experience'],
            'job' => $request['job'],
            'sex' => $request['sex'],
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = Lecturers::insertGetId($_data);
        } else {
            Lecturers::find($id)->update($_data);
        }
    }
}
