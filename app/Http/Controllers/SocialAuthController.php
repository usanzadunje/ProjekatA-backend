<?php

namespace App\Http\Controllers;

use App\Http\Responses\LoginResponse;
use App\Services\SocialAuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SocialAuthController extends Controller
{
    /*
     * Provider finished and is returning response
    */
    public function providerResponse(Request $request) : JsonResponse
    {
        $providerPayload = $request->only(['fname', 'lname', 'email', 'avatar', 'provider_id']);

        $userId = (new SocialAuthService())->createOrGetUser($providerPayload);

        if(auth()->loginUsingId($userId, true))
        {
            return app(LoginResponse::class);
        }
    }
}
