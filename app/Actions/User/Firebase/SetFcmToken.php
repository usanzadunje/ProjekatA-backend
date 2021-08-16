<?php


namespace App\Actions\User\Firebase;

use App\Models\User;

class SetFcmToken
{
    public function handle(array $validatedData, User $providedUser = null)
    {
        $user = $providedUser ?: auth()->user();
        $user->forceFill([
            'fcm_token' => $validatedData['fcm_token'],
        ])->save();
    }
}