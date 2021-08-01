<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Rules\Password;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __invoke()
    {
        return new UserResource(auth()->user());
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password))
        {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => ['required', 'string', new Password, 'confirmed'],
        ]);

        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if(!$user)
        {
            throw ValidationException::withMessages([
                'registration' => ['Something went wrong. Try again later.'],
            ]);
        }

        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return json_encode([
            'success' => 'Successfully logged out!',
        ]);
    }

    public function setFcmToken(Request $request)
    {
        $request->validate(['fcm_token' => 'required|string']);

        auth()->user()->forceFill([
            'fcm_token' => $request['fcm_token'],
        ])->save();

        return json_encode([
            'success' => 'Successfully set FCM token.',
        ]);
    }

    public function removeFcmToken()
    {
        auth()->user()->update(['fcm_token' => null]);

        return new JsonResponse('Successfully removed FCM token.', 200);
    }
}
