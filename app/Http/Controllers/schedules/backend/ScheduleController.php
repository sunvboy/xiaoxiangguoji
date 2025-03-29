<?php

namespace App\Http\Controllers\schedules\backend;

use App\Components\Helper;
use App\Components\Nestedsetbie;
use App\Components\Polylang;
use App\Http\Controllers\Controller;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ScheduleController extends Controller
{
    protected $Nestedsetbie;
    protected $Helper;
    protected $Polylang;
    protected $table = 'schedules';
    public function __construct()
    {
        $this->Nestedsetbie = new Nestedsetbie(array('table' => 'schedule_categories'));
        $this->Helper = new Helper();
        $this->Polylang = new Polylang();
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  Schedule::with('user:id,name')
            ->with('catalogues')
            ->orderBy('id', 'DESC');
        $keyword = $request->keyword;
        $schedule_category_id = $request->schedule_category_id;
        if (!empty($keyword)) {
            $data =  $data->where($this->table . '.lop_hoc', 'like', '%' . $keyword . '%');
        }
        if (!empty($schedule_category_id)) {
            $data =  $data->where('schedule_category_id', $schedule_category_id);
        }

        $data =  $data->paginate(env('APP_paginate'));

        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($schedule_category_id)) {
            $data->appends(['schedule_category_id' => $schedule_category_id]);
        }
        $htmlOption = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('schedule.backend.schedule.index', compact('data', 'htmlOption', 'configIs'));
    }
    public function create()
    {
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        return view('schedule.backend.schedule.create', compact('htmlCatalogue'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'lop_hoc' => 'required',
            'schedule_category_id' => 'required|gt:0',
        ], [
            'lop_hoc.required' => 'Lớp học là trường bắt buộc.',
            'schedule_category_id.gt' => 'Danh mục là trường bắt buộc.',
        ]);
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'schedules');
        } else {
            $image_url = $request->image_old;
        }
        $this->submit($request, 'create', 0, $image_url);
        return redirect()->route('schedules.index')->with('success', "Thêm mới lịch khai giảng thành công");
    }
    public function edit($id)
    {
        $dropdown = getFunctions();
        $detail  = Schedule::find($id);
        if (!isset($detail)) {
            return redirect()->route('courses.index')->with('error', "Lịch khai giảng không tồn tại");
        }
        $htmlCatalogue = $this->Nestedsetbie->dropdown([], config('app.locale'));
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $this->table])->get();
        return view('schedule.backend.schedule.edit', compact('detail', 'htmlCatalogue'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'lop_hoc' => 'required',
            'schedule_category_id' => 'required|gt:0',
        ], [
            'lop_hoc.required' => 'Lớp học là trường bắt buộc.',
            'schedule_category_id.gt' => 'Danh mục chính là trường bắt buộc.',
        ]);
        //upload image
        if (!empty($request->file('image'))) {
            $image_url = uploadImage($request->file('image'), 'schedules');
        } else {
            $image_url = $request->image_old;
        }
        //end
        $this->submit($request, 'update', $id, $image_url);
        return redirect()->route('schedules.index')->with('success', "Cập nhập lịch khai giảng thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $image_url = '')
    {
        if ($action == 'create') {
            $time = 'created_at';
        } else {
            $time = 'updated_at';
        }
        $_data = [
            'lop_hoc' => $request['lop_hoc'],
            'gio_hoc' => !empty($request['gio_hoc']) ? $request['gio_hoc'] : '',
            'khai_giang' => !empty($request['khai_giang']) ? $request['khai_giang'] : '',
            'ngay_hoc' => !empty($request['ngay_hoc']) ? $request['ngay_hoc'] : '',
            'so_buoi' => !empty($request['so_buoi']) ? $request['so_buoi'] : '',
            'co_so' => !empty($request['co_so']) ? $request['co_so'] : '',
            'hoc_phi' => isset($request['hoc_phi']) ? str_replace('.', '', $request['hoc_phi']) : 0,
            'schedule_category_id' => $request['schedule_category_id'],
            'user_id' => Auth::user()->id,
            $time => Carbon::now(),
        ];
        if ($action == 'create') {
            $id = Schedule::insertGetId($_data);
        } else {
            Schedule::find($id)->update($_data);
        }
    }
}
