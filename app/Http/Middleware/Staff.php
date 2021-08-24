<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Staff
{
    public function handle(Request $request, Closure $next)
    {
        if(auth()->id() === 1)
        {
            return $next($request);
        }

        abort_if(
            !auth()->user()->isStaff(),
            '403',
            'Only staff members allowed.'
        );

        return $next($request);
    }
}
