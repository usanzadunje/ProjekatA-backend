<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Fortify;

class AuthController extends Controller
{
    public function __invoke()
    {
        return new UserResource(auth()->user());
    }

    public function setFcmToken(Request $request)
    {
        $request->validate(['fcm_token' => 'required|string']);

        auth()->user()->forceFill([
            'fcm_token' => $request['fcm_token'],
        ])->save();

        return json_encode([
            'success' => 'Successfully set FCM token.'
        ]);
    }

    public function removeFcmToken()
    {
        auth()->user()->update(['fcm_token' => null]);

        return json_encode([
            'success' => 'Successfully removed FCM token.'
        ]);
    }
}
