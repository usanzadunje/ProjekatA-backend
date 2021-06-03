<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Socialite\Contracts\User as ProviderUser;

class SocialAuthService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $user = User::select('id', 'fname', 'lname', 'bday', 'phone', 'username', 'avatar', 'email', 'email_verified', 'cafe_id')
            ->where('email', $providerUser->getEmail())
            ->where('provider_id', $providerUser->getId())
            ->first();

        if(!$user)
        {
            Validator::make([
                'email' => $providerUser->getEmail(),
                'provider_id' => $providerUser->getId(),
            ], [
                'email' => [
                    Rule::unique(User::class),
                ],
                'provider_id' => [
                    Rule::unique(User::class),
                ],
            ])->validate();

            $user = User::create([
                'fname' => explode(' ', $providerUser->getName())[0],
                'lname' => explode(' ', $providerUser->getName())[1],
                'email' => $providerUser->getEmail(),
                'avatar' => $providerUser->getAvatar(),
                'provider_id' => $providerUser->getId(),
            ]);
        }

        return $user;
    }
}