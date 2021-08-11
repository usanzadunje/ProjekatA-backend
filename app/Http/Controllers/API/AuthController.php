<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Authentication\CreateOrGetSocialUser;
use App\Actions\User\Authentication\LoginUser;
use App\Actions\User\Authentication\RegisterUser;
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

        return response()->json($response);
    }

    /*
     * Provider finished and is returning response
    */
    public function social(Request $request, CreateOrGetSocialUser $createOrGetSocialUser): string
    {
        $providerPayload = $request->only(['fname', 'lname', 'email', 'avatar', 'provider_id', 'device_name']);

        $token = $createOrGetSocialUser->handle($providerPayload);

        return response()->json([
            'token' => $token,
        ]);
    }

    public function register(RegisterUserRequest $request, RegisterUser $registerUser): JsonResponse
    {
        $token = $registerUser->handle($request->validated());

        return response()->json([
            'token' => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => 'Successfully logged out!',
        ]);
    }
}
