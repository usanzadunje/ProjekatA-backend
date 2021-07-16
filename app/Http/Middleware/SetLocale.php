<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
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
        $local = ($request->hasHeader('X-Localization')) ? $request->header('X-Localization') : 'sr';

        app()->setLocale($local);

        return $next($request);
    }
}
