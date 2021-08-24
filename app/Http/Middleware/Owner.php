<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Owner
{

    public function handle(Request $request, Closure $next)
    {
        if(auth()->id() === 1)
        {
            return $next($request);
        }

        abort_if(
            !auth()->user()->isOwner(),
            '403',
            'Only owners allowed.'
        );

        return $next($request);
    }
}
