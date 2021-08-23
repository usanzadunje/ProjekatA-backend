<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Firebase\RemoveFcmToken;
use App\Actions\User\Firebase\SetFcmToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFcmTokenRequest;
use Illuminate\Http\JsonResponse;

class FirebaseController extends Controller
{
    public function setFcmToken(StoreFcmTokenRequest $request, SetFcmToken $setFcmToken): JsonResponse
    {
        $setFcmToken->handle($request->validated());

        return response()->success('Successfully set FCM token.');
    }

    public function removeFcmToken(RemoveFcmToken $removeFcmToken): JsonResponse
    {
        $removeFcmToken->handle();

        return response()->success('Successfully removed FCM token.');
    }
}
