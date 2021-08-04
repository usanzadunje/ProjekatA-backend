<?php


namespace App\Actions\User\Firebase;

class RemoveFcmToken
{
    public function handle()
    {
        auth()->user()->forceFill([
            'fcm_token' => null,
        ])->save();
    }
}