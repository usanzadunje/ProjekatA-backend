<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Authentication\CreateOrGetSocialUser;
use App\Actions\User\Authentication\LoginUser;
use App\Actions\User\Authentication\CreateUser;
use App\Actions\User\Firebase\RemoveFcmToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __invoke(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function login(LoginUserRequest $request, LoginUser $loginUser): JsonResponse
    {
        $response = $loginUser->handle($request->validated());

        return response()->success('Successfully logged in!', $response);
    }

    /*
     * Provider finished and is returning response
    */
    public function social(Request $request, CreateOrGetSocialUser $createOrGetSocialUser): JsonResponse
    {
        $providerPayload = $request->only(['fname', 'lname', 'email', 'avatar', 'provider_id', 'device_name']);

        $response = $createOrGetSocialUser->handle($providerPayload);

        return response()->success('Successfully logged in!', $response);
    }

    public function register(RegisterUserRequest $request, CreateUser $createUser): JsonResponse
    {
        $response = $createUser->handle($request->validated());

        return response()->success('Successfully registered!', $response);
    }

    public function logout(RemoveFcmToken $removeFcmToken): JsonResponse
    {
        // When staff member is logged out, set his status to inactive
        if(auth()->user()->isStaff() || auth()->user()->isOwner())
        {
            $removeFcmToken->handle(auth()->user());
        }

        if(auth()->user()->isStaff())
        {
            auth()->user()->update([
                'active' => false,
            ]);
        }

        auth()->user()->currentAccessToken()->delete();

        return response()->success('Successfully logged out!');
    }
}
