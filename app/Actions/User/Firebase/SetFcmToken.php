<?php


namespace App\Actions\User\Firebase;

class SetFcmToken
{
    public function handle(array $validatedData)
    {
        auth()->user()->forceFill([
            'fcm_token' => $validatedData['fcm_token'],
        ])->save();
    }
}