<?php

namespace App\Http\Controllers;

use App\Services\SocialAuthService;
use Illuminate\Http\Request;
use Laravel\Fortify\Contracts\LoginResponse;

class SocialAuthController extends Controller
{
    /*
     * Provider finished and is returning response
    */
    public function providerResponse(Request $request)
    {
        $providerPayload = $request->only(['fname', 'lname', 'email', 'avatar', 'provider_id']);

        $userId = (new SocialAuthService())->createOrGetUser($providerPayload);

        if(auth()->loginUsingId($userId, true))
        {
            return app(LoginResponse::class);
        }
    }
}
