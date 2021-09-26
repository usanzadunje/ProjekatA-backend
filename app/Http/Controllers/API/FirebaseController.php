<?php

namespace App\Http\Controllers\API;

use App\Actions\User\Firebase\RemoveFcmToken;
use App\Actions\User\Firebase\SetFcmToken;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFcmTokenRequest;

class FirebaseController extends Controller
{
    public function store(StoreFcmTokenRequest $request, SetFcmToken $setFcmToken): void
    {
        $setFcmToken->handle($request->validated());
    }

    public function destroy(RemoveFcmToken $removeFcmToken): void
    {
        $removeFcmToken->handle();
    }
}
