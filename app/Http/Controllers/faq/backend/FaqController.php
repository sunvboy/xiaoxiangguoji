<?php

namespace App\Http\Controllers\faq\backend;

use App\Http\Controllers\Controller;

use App\Models\Faq;
use App\Models\FaqCategory;
use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\View;

class FaqController extends Controller
{

    protected $table = 'faqs';

    public function __construct()

    {

        View::share(['module' => $this->table]);
    }

    public function index(Request $request)

    {
        $data =  Faq::orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('faq.backend.index', compact('data'));
    }

    public function create()

    {
        $action = 'create';
        $categories = dropdown(FaqCategory::get(), 'Chọn danh mục', 'id', 'title');
        return view('faq.backend.create', compact('action', 'categories'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'catalogue_id' => 'required|gt:0',
            'name' => 'required',
            'content' => 'required',
            'reply' => 'required',
        ], [
            'catalogue_id.required' => 'Danh mục là trường bắt buộc.',
            'catalogue_id.gt' => 'Danh mục là trường bắt buộc.',
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'name.required' => 'Họ và tên người hỏi là trường bắt buộc.',
            'content.required' => 'Nội dung người hỏi là trường bắt buộc.',
            'reply.required' => 'Trả lời người hỏi là trường bắt buộc.',
        ]);

        $validator->validate();
        $this->submit($request, 'create', 0);
        return redirect()->route('faqs.index')->with('success', "Thêm mới câu hỏi thường gặp thành công");
    }

    public function edit($id)

    {
        $detail  = Faq::find($id);
        if (!isset($detail)) {

            return redirect()->route('faqs.index')->with('error', "Đối tác không tồn tại");
        }

        $action = 'update';
        $categories = dropdown(FaqCategory::get(), 'Chọn danh mục', 'id', 'title');

        return view('faq.backend.create', compact('action', 'detail', 'categories'));
    }

    public function update(Request $request, $id)

    {

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'catalogue_id' => 'required|gt:0',
            'name' => 'required',
            'content' => 'required',
            'reply' => 'required',
        ], [
            'catalogue_id.required' => 'Danh mục là trường bắt buộc.',
            'catalogue_id.gt' => 'Danh mục là trường bắt buộc.',
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'name.required' => 'Họ và tên người hỏi là trường bắt buộc.',
            'content.required' => 'Nội dung người hỏi là trường bắt buộc.',
            'reply.required' => 'Trả lời người hỏi là trường bắt buộc.',
        ]);

        $validator->validate();

        //upload image


        //end

        $this->submit($request, 'update', $id);

        return redirect()->route('faqs.index')->with('success', "Cập nhập câu hỏi thường gặp thành công");
    }

    public function submit($request = [], $action = '', $id = 0)

    {

        if ($action == 'create') {

            $time = 'created_at';
        } else {

            $time = 'updated_at';
        }

        $_data = [

            'title' => $request['title'],

            'content' => $request['content'],
            'name' => $request['name'],
            'reply' => $request['reply'],
            'catalogue_id' => $request['catalogue_id'],

            'user_id' => Auth::user()->id,

            $time => Carbon::now(),

        ];

        if ($action == 'create') {

            $id = Faq::insertGetId($_data);
        } else {
            Faq::find($id)->update($_data);
        }
    }
}
