<?php

namespace App\Http\Controllers\config;

use App\Http\Controllers\Controller;
use App\Models\ConfigImage;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ConfigImageController extends Controller
{
    protected $module = 'config_images';
    protected $table = [
        'products' => 'Sản phẩm',
        'category_products' => 'Danh mục sản phẩm',
        'articles' => 'Bài viết',
        'category_articles' => 'Danh mục bài viết',
        'media' => 'Media',
        'category_media' => 'Danh mục media',
    ];
    public function index()
    {
        $module = $this->module;
        $data = ConfigImage::get();
        return view('config.images.index', compact('module', 'data'));
    }
    public function create()
    {
        $module  = $this->module;
        $table = $this->table;
        return view('config.images.create', compact('module', 'table'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'module' => 'required',
        ]);
        $_data = [
            'module' => $request->module,
            'data' => json_encode($request->data),
            'created_at' => Carbon::now(),
        ];
        $id = ConfigImage::insertGetId($_data);
        if ($id > 0) {
            return redirect()->route('config_images.index')->with('success', "Thêm mới thành công");
        }
    }
    public function edit($id)
    {
        $detail  = ConfigImage::find($id);
        $table = $this->table;
        if (!isset($detail)) {
            return redirect()->route('config_images.index')->with('error', "Không tồn tại");
        }
        $module = $this->module;
        return view('config.images.edit', compact('module', 'detail', 'table'));
    }
    public function update(Request $request, $id)
    {

        $_data = [
            'data' => json_encode($request->data),
            'updated_at' => Carbon::now(),
        ];
        $check = ConfigImage::find($id)->update($_data);
        if ($check) {
            return redirect()->route('config_images.edit', ['id' => $id])->with('success', "Cập nhập thành công");
        }
    }
}
