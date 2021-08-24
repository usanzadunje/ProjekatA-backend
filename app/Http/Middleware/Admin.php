<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Admin
{

    public function handle(Request $request, Closure $next)
    {
        abort_if(
            auth()->id() !== 1,
            '403',
            'You are not welcome here.'
        );

        return $next($request);
    }
}
