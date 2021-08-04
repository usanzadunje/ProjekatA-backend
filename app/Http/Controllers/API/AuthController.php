<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Authentication\LoginUser;
use App\Actions\User\Authentication\RegisterUser;
use App\Actions\User\Firebase\RemoveFcmToken;
use App\Actions\User\Firebase\SetFcmToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\StoreFcmTokenRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    public function __invoke(): UserResource
    {
        return new UserResource(auth()->user());
    }

    public function login(LoginUserRequest $request, LoginUser $loginUser): JsonResponse
    {
        $user = $loginUser->handle($request->validated());

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
        ]);
    }

    public function register(RegisterUserRequest $request, RegisterUser $registerUser): JsonResponse
    {
        $user = $registerUser->handle($request->validated());

        $token = $user->createToken($request->device_name)->plainTextToken;

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

    public function setFcmToken(StoreFcmTokenRequest $request, SetFcmToken $setFcmToken): JsonResponse
    {
        $setFcmToken->handle($request->validated());

        return response()->json([
            'success' => 'Successfully set FCM token.',
        ]);
    }

    public function removeFcmToken(RemoveFcmToken $removeFcmToken): JsonResponse
    {
        $removeFcmToken->handle();

        return response()->json([
            'success' => 'Successfully removed FCM token.',
        ]);
    }
}
