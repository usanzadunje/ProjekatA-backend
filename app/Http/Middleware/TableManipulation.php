<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TableManipulation
{

    public function handle(Request $request, Closure $next)
    {
        if(auth()->id() === 1 || auth()->user()->isStaff() || auth()->user()->isOwner())
        {
            return $next($request);
        }

        abort(
            '403',
            'You are not allowed here'
        );
    }
}
