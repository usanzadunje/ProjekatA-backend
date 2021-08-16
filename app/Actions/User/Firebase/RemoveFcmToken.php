<?php


namespace App\Actions\User\Firebase;

use App\Models\User;

class RemoveFcmToken
{
    public function handle(User $providedUser = null)
    {
        $user = $providedUser ?: auth()->user();
        $user->forceFill([
            'fcm_token' => null,
        ])->save();
    }
}