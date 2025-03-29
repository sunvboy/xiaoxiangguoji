<?php

namespace App\Http\Controllers\general;

use App\Http\Controllers\Controller;
use App\Models\General;
use App\Models\Generals_is;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{
    protected $module = 'generals';
    public function index()
    {
        $module = $this->module;
        $dropdown = getFunctions();
        return view('general.index', compact('module', 'dropdown'));
    }
    public function general()
    {
        $tab = config('system');
        $general = General::latest()->get();
        $systems = [];
        foreach ($general as $key => $val) {

            if (config('app.locale') == 'en') {
                $language = $val['content_en'];
            } else if (config('app.locale') == 'gm') {
                $language = $val['content_gm'];
            } else if (config('app.locale') == 'tl') {
                $language = $val['content_tl'];
            } else {
                $language = $val['content'];
            }
            $systems[$val['keyword']] = $language;
        }
        $module = $this->module;
        return view('general.general', compact('module', 'tab', 'systems'));
    }

    public function store(Request $request)
    {
        $config = $request->config;
        $_create = [];
        // General::truncate();
        if (isset($config) && is_array($config) && count($config)) {
            foreach ($config as $key => $val) {

                if (config('app.locale') == 'en') {
                    $language = 'content_en';
                } else  if (config('app.locale') == 'tl') {
                    $language = 'content_tl';
                } else if (config('app.locale') == 'gm') {
                    $language = 'content_gm';
                } else {
                    $language = 'content';
                }
                $_create = array(
                    'keyword' => $key,
                    $language =>  !empty($val) ? $val : '',
                    'userid_created' => Auth::user()->id,
                    'created_at' => gmdate('Y-m-d H:i:s', time() + 7 * 3600),
                );
                $flag = $this->_Check($key);

                if ($flag == FALSE) {
                    $slide = DB::table('generals')->insert($_create);
                } else {
                    $slide = DB::table('generals')->where("keyword", $key)->update($_create);
                }
            }
        }

        return redirect()->route('generals.general')->with('success', 'Cập nhập thành công');
    }
    public function _Check($keyword = '')
    {
        $result = General::where('keyword', $keyword)->get()->count();
        return (($result >= 1) ? TRUE : FALSE);
    }

    public function generals_is_index(Request $request)
    {
        $module = 'generals_is';
        $data = Generals_is::get();
        $table = [
            'category_products' => 'Danh mục sản phẩm',
            'products' => 'Sản phẩm',
            'category_articles' => 'Danh mục bài viết',
            'articles' => 'Bài viết',
            'category_attributes' => 'Danh mục thuộc tính',
            'attributes' => 'Thuộc tính',
            'category_media' => 'Danh mục media',
            'media' => 'Media',
        ];
        return view('general.general_is', compact('module', 'data', 'table'));
    }
}
