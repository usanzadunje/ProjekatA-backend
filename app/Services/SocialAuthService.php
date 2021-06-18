<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SocialAuthService
{
    public function createOrGetUser($providerPayload)
    {
        $user = User::select('id')
            ->where('email', $providerPayload['email'])
            ->where('provider_id', $providerPayload['provider_id'])
            ->first();

        if(!$user)
        {
            Validator::make($providerPayload, [
                    'email' => [
                        Rule::unique(User::class),
                    ],
                    'provider_id' => [
                        Rule::unique(User::class),
                    ],]
            )->validate();

            $user = User::create([
                'fname' => $providerPayload['fname'],
                'lname' => $providerPayload['lname'],
                'email' => $providerPayload['email'],
                'email_verified_at' => now(),
                'avatar' => $providerPayload['avatar'],
                'provider_id' => $providerPayload['provider_id'],
            ]);
        }

        return $user->id;
    }
}