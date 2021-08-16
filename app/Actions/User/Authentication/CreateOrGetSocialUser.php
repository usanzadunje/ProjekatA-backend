<?php

namespace App\Actions\User\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateOrGetSocialUser
{
    public function handle($providerPayload) : array
    {
        $user = User::select('id')
            ->where('email', $providerPayload['email'])
            ->where('provider_id', $providerPayload['provider_id'])
            ->firstOrFail();

        if(!$user)
        {
            Validator::make($providerPayload, [
                    'email' => [
                        Rule::unique(User::class),
                    ],
                    'provider_id' => [
                        Rule::unique(User::class),
                    ],
                    'device_name' => [
                        'required'
                    ],
                ]
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

        $userInfo = [
            'token' => $user->createToken($providerPayload['device_name'])->plainTextToken
        ];

        return $userInfo;
    }
}