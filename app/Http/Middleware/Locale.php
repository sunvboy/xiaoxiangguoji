<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\Artisan;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $segments = request()->segments();
        $last  = end($segments);
        $first = reset($segments);
        if (!empty($first) && $first != env('APP_ADMIN')) {
            if (in_array($first, config('app.alt_langs'))) {
                config(['app.locale' => $first]);
            } else {
                config(['app.locale' => 'vi']);
            }
            Artisan::call('cache:clear');
        } else if ($first == env('APP_ADMIN')) {
            // Lấy dữ liệu lưu trong Session, không có thì trả về default lấy trong config
            $language = Session::get('language', config('app.locale'));
            config(['app.locale' => $language]);
        } else {
            config(['app.locale' => 'vi']);
            Artisan::call('cache:clear');
        }
        return $next($request);
    }
}
