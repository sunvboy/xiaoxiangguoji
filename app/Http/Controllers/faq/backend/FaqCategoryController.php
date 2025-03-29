<?php

namespace App\Http\Controllers\faq\backend;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class FaqCategoryController extends Controller
{
    protected $table = 'faq_categories';

    public function __construct()

    {

        View::share(['module' => $this->table]);
    }

    public function index(Request $request)

    {
        $data =  FaqCategory::orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('faq.backend.category.index', compact('data'));
    }

    public function create()

    {
        $action = 'create';
        return view('faq.backend.category.create', compact('action'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'slug' => 'required|unique:faq_categories',

        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
        ]);

        $validator->validate();
        $this->submit($request, 'create', 0);
        return redirect()->route('faq_categories.index')->with('success', "Thêm mới câu hỏi thường gặp thành công");
    }

    public function edit($id)

    {
        $detail  = FaqCategory::find($id);
        if (!isset($detail)) {

            return redirect()->route('faq_categories.index')->with('error', "Đối tác không tồn tại");
        }
        $action = 'update';

        return view('faq.backend.category.create', compact('action', 'detail'));
    }

    public function update(Request $request, $id)

    {

        $validator = Validator::make($request->all(), [

            'title' => 'required',
            'slug' => ['required', Rule::unique('faq_categories')->where(function ($query) use ($id) {
                return $query->where('id', '!=', $id);
            })],
        ], [

            'title.required' => 'Tên tag là trường bắt buộc.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',
        ]);

        $validator->validate();

        //upload image


        //end

        $this->submit($request, 'update', $id);

        return redirect()->route('faq_categories.index')->with('success', "Cập nhập câu hỏi thường gặp thành công");
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

            'slug' => $request['slug'],

            'user_id' => Auth::user()->id,

            $time => Carbon::now(),

        ];

        if ($action == 'create') {

            $id = FaqCategory::insertGetId($_data);
        } else {
            FaqCategory::find($id)->update($_data);
        }
    }
}
