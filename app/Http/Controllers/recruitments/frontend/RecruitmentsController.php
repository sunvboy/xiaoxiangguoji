<?php

namespace App\Http\Controllers\recruitments\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Recruitment;
use Carbon\Carbon;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;

class RecruitmentsController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index($slug)
    {
        $detail = Recruitment::select()
            ->where(['slug' => $slug])
            ->first();
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        //bài viết liên quan
        //cập nhập lượt xem
        DB::table('recruitments')->where('id', '=', $detail['id'])->update([
            'viewed' => $detail['viewed'] + 1,
        ]);
        $sameArticle =  Recruitment::where('id', '!=', $detail->id)->limit(4)->get();
        $fcSystem = $this->system->fcSystem();
        $seo['canonical'] = route('recruitment', ['slug' => $slug]);
        $seo['meta_title'] =  !empty($detail['meta_title']) ? $detail['meta_title'] : $detail['title'];
        $seo['meta_description'] = !empty($detail['meta_description']) ? $detail['meta_description'] : cutnchar(strip_tags($detail->description));
        $seo['meta_image'] = $detail['image'];
        return view('article.frontend.article.recruitment', compact('fcSystem', 'detail', 'seo',  'sameArticle'));
    }
}
