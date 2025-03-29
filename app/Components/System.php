<?php

namespace App\Components;

use View;
use Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class System
{
    function fcSystem()
    {
        $fcSystem = [];
        if (!empty(Auth::user())) {
            $system = \App\Models\General::select('keyword', 'content', 'content_en')->get();
        } else {
            $system = Cache::remember('system', 600000, function () {
                $system = \App\Models\General::select('keyword', 'content', 'content_en')->get();
                return $system;
            });
        }
        if (isset($system)) {
            foreach ($system as $val) {
                if (config('app.locale') == config('app.locale_prefix')) {
                    $language = $val['content_' . config('app.locale_prefix')];
                } else {
                    $language = $val['content'];
                }
                $fcSystem[$val['keyword']] = $language;
            }
        }
        $segments = request()->segments();
        $first = reset($segments);
        $last  = end($segments);
        if (in_array($first, config('app.alt_langs'))) {
            $url = collect($segments)->slice(1)->join('', '/');
            $fcSystem['language_vi'] = asset($url);
            foreach (config('app.alt_langs') as $lang) {
                $fcSystem['language_' . $lang] = asset($lang . '/' . $url);
            }
        } else {
            $url = collect($segments)->join('', '/');
            $fcSystem['language_vi'] = asset($url);
            foreach (config('app.alt_langs') as $lang) {
                $fcSystem['language_' . $lang] = asset($lang . '/' . $url);
            }
        }
        return $fcSystem;
    }
}
