<?php

namespace App\Http\Controllers\faq\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\FaqCategory;
use App\Models\Page;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index($id)
    {
        $detail =  Faq::find($id);
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'faqs', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $seo['canonical'] = route('router.team', ['id' => $detail->id]);
        $seo['meta_title'] =  $detail->name;
        $seo['meta_description'] = '';
        $seo['meta_image'] = asset($detail->image);
        $fcSystem = $this->system->fcSystem();
        return view('faq.frontend.index', compact('fcSystem', 'detail', 'seo', 'page'));
    }
    public function category($slug)
    {
        $detail =  FaqCategory::where('slug', $slug)->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $data =  Faq::where('catalogue_id', $detail->id)->orderBy('order', 'asc')->orderBy('id', 'DESC');
        $data =  $data->paginate(10);
        $page = Page::where(['alanguage' => config('app.locale'), 'page' => 'faqs', 'publish' => 0])
            ->select('id', 'image', 'title', 'description', 'meta_title', 'meta_description')
            ->with('fields')
            ->first();
        $seo['canonical'] = route('router.team', ['id' => $detail->id]);
        $seo['meta_title'] =  $detail->name;
        $seo['meta_description'] = '';
        $seo['meta_image'] = asset($detail->image);
        $fcSystem = $this->system->fcSystem();
        return view('faq.frontend.category', compact('fcSystem', 'detail', 'seo', 'page', 'data'));
    }
}
