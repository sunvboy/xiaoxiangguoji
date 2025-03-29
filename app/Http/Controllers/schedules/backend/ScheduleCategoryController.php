<?php

namespace App\Http\Controllers\schedules\backend;

use App\Components\Nestedsetbie;
use App\Components\Polylang;
use App\Http\Controllers\Controller;
use App\Models\ScheduleCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class ScheduleCategoryController extends Controller
{
    protected $nestedsetbie;
    protected $Polylang;
    protected $table = 'schedule_categories';
    public function __construct()
    {
        $this->nestedsetbie = new Nestedsetbie(array('table' => $this->table));
        $this->Polylang = new Polylang();
        View::share(['module' => $this->table]);
    }
    public function index(Request $request)
    {
        $data =  ScheduleCategory::where('alanguage', config('app.locale'))->with('user')->with('schedules')->orderBy('lft', 'ASC');
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
        return view('schedule.backend.category.index', compact('data', 'configIs'));
    }


    public function create()
    {
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $this->table])->get();
        return view('schedule.backend.category.create', compact('htmlCatalogue', 'field'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' =>  ['required', Rule::unique('router')->where(function ($query) use ($request) {
            //     return $query->where('alanguage', config('app.locale'));
            // })],
        ], [
            'title.required' => 'Tên danh mục là trường bắt buộc.',
            // 'slug.required' => 'Đường dẫn danh mục là trường bắt buộc.',
            // 'slug.unique' => 'Đường dẫn danh mục đã tồn tại.',
        ]);
        //upload image,banner,...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'schedule-categories');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'schedule-categories');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'create', 0, $arrayImg);
        return redirect()->route('schedule_categories.index')->with('success', "Thêm mới nhóm lịch khai giảng thành công");
    }

    public function edit($id)
    {
        $detail  = ScheduleCategory::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('schedule_categories.index')->with('error', "Nhóm lịch khai giảng không tồn tại");
        }
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $this->table])->get();
        return view('schedule.backend.category.edit', compact('detail', 'htmlCatalogue', 'field'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            // 'slug' => 'required|unique:router,slug,' . $id . ',moduleid,alanguage,' . config('app.locale') . '',
            // 'slug' => ['required', Rule::unique('router')->where(function ($query) use ($id) {
            //     return $query->where('moduleid', '!=', $id)->where('alanguage', config('app.locale'));
            // })],
        ], [
            'title.required' => 'Tiêu đề là trường bắt buộc.',
            // 'slug.required' => 'Đường dẫn là trường bắt buộc.',
            // 'slug.unique' => 'Đường dẫn đã tồn tại.',
        ]);
        //upload image,banner...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'schedule-categories');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'schedule-categories');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('schedule_categories.index')->with('success', "Cập nhập nhóm lịch khai giảng thành công");
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
            $id = ScheduleCategory::insertGetId($_data);
        } else {
            ScheduleCategory::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                $this->Polylang->insert($this->table, $request['language'], $id);
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //xóa khi cập nhập
            //START: custom fields
            fieldsInsert(
                $this->table,
                $id,
                $request
            );

            //END
            $this->nestedsetbie->Get();
            $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
            $this->nestedsetbie->Action();
        }
    }
}
