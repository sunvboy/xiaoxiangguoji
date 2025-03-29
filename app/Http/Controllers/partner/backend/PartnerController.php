<?php

namespace App\Http\Controllers\partner\backend;

use App\Http\Controllers\Controller;
use App\Models\Partner;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\View;

class PartnerController extends Controller
{
    protected $table = 'partners';
    public function __construct()
    {
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  Partner::orderBy('id', 'DESC');
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
        return view('partner.backend.index', compact('data', 'configIs'));
    }
    public function create()
    {
        $action = 'create';
        return view('partner.backend.create', compact('action'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
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
        return redirect()->route('partners.index')->with('success', "Thêm mới đối tác thành công");
    }
    public function edit($id)
    {
        $detail  = Partner::find($id);
        if (!isset($detail)) {
            return redirect()->route('partners.index')->with('error', "Đối tác không tồn tại");
        }
        $action = 'update';
        return view('partner.backend.create', compact('action', 'detail'));
    }
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',

        ], [
            'title.required' => 'Tên tag là trường bắt buộc.',
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
        return redirect()->route('partners.index')->with('success', "Cập nhập đối tác thành công");
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
            'image' => $image_url,
            'link' => $request['link'],
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = Partner::insertGetId($_data);
        } else {
            Partner::find($id)->update($_data);
        }
    }
}
