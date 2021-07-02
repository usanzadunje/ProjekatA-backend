<?php

namespace App\Http\Controllers;

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
        $providerPayload = $request->only(['fname', 'lname', 'email', 'avatar', 'provider_id', 'device_name']);

        $user = (new SocialAuthService())->createOrGetUser($providerPayload);

        return $user->createToken($request->device_name)->plainTextToken;
    }
}
