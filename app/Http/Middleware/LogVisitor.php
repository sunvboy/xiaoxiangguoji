<?php

namespace App\Http\Middleware;

use App\Models\Visitor;
use Closure;
use Illuminate\Http\Request;

class LogVisitor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Visitor::updateOrCreate(
        //     ['ip_address' => $request->ip(), 'user_agent' => $request->userAgent()],
        //     ['url' => $request->url(), 'user_agent' => $request->userAgent(), 'visited_at' => now()]
        // );
        return $next($request);
    }
}
