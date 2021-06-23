<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\RegisterResponse as RegisterResponseContract;

class RegisterResponse implements RegisterResponseContract
{
    /**
     * @param  $request
     * @return JsonResponse
     */
    public function toResponse($request) : JsonResponse
    {
        return new JsonResponse('true', '200');
    }
}