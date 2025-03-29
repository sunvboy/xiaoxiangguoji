<?php

namespace App\Http\Controllers\faculty\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Faculty;
use App\Models\FacultyCategory;
use Illuminate\Http\Request;

class FacultiesController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index($slug = "")
    {
        $segments = request()->segments();
        $slug = end($segments);
        $detail = Faculty::select()
            ->where(['slug' => $slug, 'alanguage' => config('app.locale'), 'publish' => 0])
            ->with('faculty_categories:id,slug,title')
            ->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $catalogues = $detail->faculty_categories;
        $fcSystem = $this->system->fcSystem();
        $FacultyCategory =  FacultyCategory::where('alanguage', config('app.locale'))->where('id', $detail->faculty_category_id)->orderBy('order', 'asc')->orderBy('id', 'desc')->get();

        $seo['canonical'] = route('routerURL', ['slug' => $slug]);
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        $fcSystem = $this->system->fcSystem();
        return view('faculty.frontend.faculty.index', compact('fcSystem', 'detail', 'seo', 'FacultyCategory'));
    }
}
