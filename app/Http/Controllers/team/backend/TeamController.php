<?php

namespace App\Http\Controllers\team\backend;

use App\Http\Controllers\Controller;
use App\Models\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\View;


class TeamController extends Controller
{
    protected $table = 'teams';
    public function __construct()

    {
        View::share(['module' => $this->table]);
    }

    public function index(Request $request)
    {
        $data =  Team::orderBy('id', 'DESC');
        $keyword = $request->keyword;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        return view('team.backend.index', compact('data'));
    }
    public function create()
    {
        $action = 'create';
        return view('team.backend.create', compact('action'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'Họ và tên là trường bắt buộc.',
        ]);

        $validator->validate();
        if (!empty($request->file('image'))) {

            $image_url = uploadImage($request->file('image'), $this->table);
        } else {

            $image_url = $request->image_old;
        }

        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('teams.index')->with('success', "Thêm mới câu hỏi thường gặp thành công");
    }

    public function edit($id)

    {
        $detail  = Team::find($id);
        if (!isset($detail)) {

            return redirect()->route('teams.index')->with('error', "Đối tác không tồn tại");
        }

        $action = 'update';

        return view('team.backend.create', compact('action', 'detail'));
    }

    public function update(Request $request, $id)

    {

        $validator = Validator::make($request->all(), [

            'name' => 'required',



        ], [

            'name.required' => 'Tên tag là trường bắt buộc.',

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

        return redirect()->route('teams.index')->with('success', "Cập nhập câu hỏi thường gặp thành công");
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
            'dao_tao' => $request['dao_tao'],
            'the_manh' => $request['the_manh'],

            'job' => $request['job'],
            'image' => $image_url,

            'user_id' => Auth::user()->id,

            $time => Carbon::now(),

        ];

        if ($action == 'create') {

            $id = Team::insertGetId($_data);
        } else {
            Team::find($id)->update($_data);
        }
    }
}
