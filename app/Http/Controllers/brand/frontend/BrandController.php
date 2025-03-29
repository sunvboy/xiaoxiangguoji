<?php

namespace App\Http\Controllers\brand\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Components\System;

class BrandController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index(Request $request, $slug = "")
    {

        $detail = Brand::where(['alanguage' => config('app.locale'), 'slug' => $slug, 'publish' => 0])->with('brands_relationships')->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index')->with('error', 'Thương hiệu không tồn tại');
        }
        $sort = '';
        if (!empty($_GET['sort'])) {
            $sort = $_GET['sort'];
        }
        $arrayProduct = $detail->brands_relationships->pluck('product_id');
        $data =  \App\Models\Product::whereIn('id', $arrayProduct);
        if (!empty($sort)) {
            $sort = explode('|', $sort);
            if (count($sort) == 2) {
                $data =  $data->orderBy($sort[0], $sort[1]);
            } else {
                return redirect()->route('brandURL', ['slug' => $slug]);
            }
        } else {
            $data =  $data->orderBy('order', 'asc')->orderBy('id', 'desc');
        }
        $data =  $data->paginate(28);
        if (is($sort)) {
            $data->appends(['sort' => $request->sort]);
        }
        $attribute_tmp = \App\Models\CategoryAttribute::select('id', 'title', 'slug as keyword')
            ->where(['alanguage' => config('app.locale'), 'publish' => 0, 'ishome' => 0])
            ->orderBy('order', 'asc')
            ->orderBy('id', 'desc')
            ->with('listAttr')
            ->get();
        $attributes = [];
        if (!empty($attribute_tmp)) {
            foreach ($attribute_tmp as $item) {
                if (count($item->listAttr)) {
                    foreach ($item->listAttr as $attr) {
                        $attributes[] = array(
                            'id' => $attr->id,
                            'title' => $attr->title,
                            'titleC' => $item->title,
                            'keyword' => $item->keyword,
                        );
                    }
                }
            }
        }
        $attributes = collect($attributes)->groupBy('titleC')->all();
        $seo['canonical'] = $request->url();
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('brand.frontend.index', compact('fcSystem', 'detail', 'seo', 'data', 'attributes'));
    }
}
