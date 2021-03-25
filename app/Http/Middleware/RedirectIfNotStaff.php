<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;

class RedirectIfNotStaff
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
        if(!auth()->user()->isStaff()){
            if ($request->expectsJson()) {
                return response()->json(['error' => 'You do not have permission to do that.'], 403);
            }
            return redirect(RouteServiceProvider::HOME);
        }
            return $next($request);
    }
}
