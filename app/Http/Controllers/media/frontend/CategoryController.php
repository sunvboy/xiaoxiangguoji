<?php

namespace App\Http\Controllers\media\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Components\System;
use App\Models\CategoryMedia;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->system = new System();
    }
    public function index($slug = "", Request $request)
    {

        $segments = request()->segments();
        $slug = end($segments);
        $detail = CategoryMedia::select('id', 'slug', 'title', 'description', 'meta_description', 'meta_title', 'publish', 'lft', 'image', 'layoutid')
            ->where('alanguage', config('app.locale'))
            ->where('publish', 0)
            ->with(['children' => function ($q) {
                $q->with(['posts6']);
            }])
            ->where('slug', $slug)
            ->first();

        // dd(config('app.locale'));

        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }

        $data = \App\Models\Catalogues_relationships::where(['catalogueid' => $detail->id, 'module' => 'media', 'media.publish' => 0])
            ->join('media', 'media.id', '=', 'catalogues_relationships.moduleid')
            ->with('tagsArticle')
            ->orderBy('media.id', 'desc')
            ->paginate(18);

        // breadcrumb

        $breadcrumb = CategoryMedia::select('title', 'slug')->where('alanguage', config('app.locale'))->where('lft', '<=', $detail->lft)->where('rgt', '>=', $detail->lft)->orderBy('lft', 'ASC')->orderBy('order', 'ASC')->get();
        $seo['canonical'] = route('routerURL', ['slug' => $slug]);
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        $polylang = langURLFrontend('category_media', config('app.locale'), $detail->id, '\App\Models\CategoryMedia');
        if (!empty($polylang)) {
            foreach ($polylang as $key => $item) {
                $fcSystem['language_' . $key] = $item;
            }
        }
        if ($detail->layoutid == 2) {
            return view('media.frontend.category.gallery', compact('fcSystem', 'detail', 'seo', 'data', 'breadcrumb'));
        } else {
            return view('media.frontend.category.index', compact('fcSystem', 'detail', 'seo', 'data', 'breadcrumb'));
        }
    }
}
