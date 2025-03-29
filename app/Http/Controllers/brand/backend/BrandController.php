<?php

namespace App\Http\Controllers\brand\backend;

use App\Http\Controllers\Controller;
use App\Components\Nestedsetbie;
use App\Models\Brand;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Validator;

class BrandController extends Controller
{
    protected $table = 'brands';
    public function __construct()
    {
        $this->nestedsetbie = new Nestedsetbie(array('table' => $this->table));
    }
    public function index(Request $request)
    {
        $data =  Brand::where('alanguage', config('app.locale'))->orderBy('lft', 'ASC');
        $keyword = $request->keyword;
        $type = $request->type;
        if (!empty($keyword)) {
            $data =  $data->where('title', 'like', '%' . $keyword . '%');
        }
        if (!empty($type)) {
            $data =  $data->where($this->table . '.' . $type,  1);
        }
        $data =  $data->paginate(env('APP_paginate'));
        if (is($keyword)) {
            $data->appends(['keyword' => $keyword]);
        }
        if (is($type)) {
            $data->appends(['type' => $type]);
        }
        $module = $this->table;
        $configIs = \App\Models\Configis::select('title', 'type')->where(['module' => $this->table, 'active' => 1])->get();
        return view('brand.backend.brand.index', compact('module', 'data', 'module', 'configIs'));
    }
    public function create()
    {
        $module = $this->table;
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        return view('brand.backend.brand.create', compact('module', 'field', 'htmlCatalogue'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:brands',
            'slug' => 'required|unique:brands',
        ], [
            'title.required' => 'Tên thương hiệu là trường bắt buộc.',
            'title.unique' => 'Tên thương hiệu đã tồn tại.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',

        ]);
        //upload image,banner,...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'thuong-hieu');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'thuong-hieu/banner');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'create', 0, $arrayImg);
        return redirect()->route('brands.index')->with('success', "Thêm mới thương hiệu thành công");
    }
    public function edit($id)
    {
        $detail  = Brand::where('alanguage', config('app.locale'))->find($id);
        if (!isset($detail)) {
            return redirect()->route('brands.index')->with('error', "Thương hiệu không tồn tại");
        }
        $module = $this->table;
        $field = \App\Models\ConfigColum::where(['trash' => 0, 'publish' => 0, 'module' => $module])->get();
        $htmlCatalogue = $this->nestedsetbie->dropdown([], config('app.locale'));
        return view('brand.backend.brand.edit', compact('module', 'detail', 'field', 'htmlCatalogue'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:brands,slug,' . $id . ',id',
            'slug' => 'required|unique:brands,slug,' . $id . ',id',
        ], [
            'title.required' => 'Tên thương hiệu là trường bắt buộc.',
            'title.unique' => 'Tên thương hiệu đã tồn tại.',
            'slug.required' => 'Đường dẫn là trường bắt buộc.',
            'slug.unique' => 'Đường dẫn đã tồn tại.',

        ]);
        //upload image,banner,...
        if (!empty($request->file('image'))) {
            $image_url = uploadImageNone($request->file('image'), 'thuong-hieu');
        } else {
            $image_url = $request->image_old;
        }
        if (!empty($request->file('banner'))) {
            $banner_url = uploadImageNone($request->file('banner'), 'thuong-hieu/banner');
        } else {
            $banner_url = $request->banner_old;
        }
        $arrayImg = [
            'image_url' => $image_url,
            'banner_url' => $banner_url
        ];
        //end
        $this->submit($request, 'update', $id, $arrayImg);
        return redirect()->route('brands.index')->with('success', "Cập nhập thương hiệu thành công");
    }
    public function submit($request = [], $action = '', $id = 0, $arrayImg = [])
    {
        if ($action == 'create') {
            $time = 'created_at';
            $user = 'userid_created';
        } else {
            $time = 'updated_at';
            $user = 'userid_updated';
        }
        $_data = [
            'title' => $request['title'],
            'slug' => $request['slug'],
            'parentid' => $request['parentid'],
            'image' =>  $arrayImg['image_url'],
            'banner' => $arrayImg['banner_url'],
            'description' => $request['description'],
            'meta_title' => $request['meta_title'],
            'meta_description' => $request['meta_description'],
            'publish' => $request['publish'],
            $user => Auth::user()->id,
            $time => Carbon::now(),
            'alanguage' => config('app.locale'),
        ];
        if ($action == 'create') {
            $id = Brand::insertGetId($_data);
        } else {
            Brand::find($id)->update($_data);
        }
        if (!empty($id)) {
            //xóa khi cập nhập
            if ($action == 'update') {
                //xóa custom fields
                DB::table('config_postmetas')->where(['module_id' => $id, 'module' => $this->table])->delete();
            }
            //START: custom fields
            fieldsInsert($this->table, $id, $request);
            //END
            $this->nestedsetbie->Get();
            $this->nestedsetbie->Recursive(0, $this->nestedsetbie->Set());
            $this->nestedsetbie->Action();
        }
    }
}
