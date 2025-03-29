<?php

namespace App\Http\Controllers\team\frontend;

use App\Components\System;
use App\Http\Controllers\Controller;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    protected $system;
    public function __construct()
    {
        $this->system = new System();
    }
    public function index($id)
    {
        $detail =  Team::find($id);
        if (!isset($detail)) {
            return redirect()->route('homepage.index');
        }
        $seo['canonical'] = route('router.team', ['id' => $detail->id]);
        $seo['meta_title'] =  $detail->name;
        $seo['meta_description'] = '';
        $seo['meta_image'] = asset($detail->image);
        $fcSystem = $this->system->fcSystem();
        return view('team.frontend.index', compact('fcSystem', 'detail', 'seo'));
    }
}
