<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SocialAuthService
{
    public function createOrGetUser($providerUser)
    {
        $user = User::select('id', 'fname', 'lname', 'bday', 'phone', 'username', 'avatar', 'email', 'email_verified_at', 'cafe_id')
            ->where('email', $providerUser->email)
            ->where('provider_id', $providerUser->provider_id)
            ->first();

        if(!$user)
        {
            Validator::make([
                'email' => $providerUser->email,
                'provider_id' => $providerUser->email,
            ], [
                'email' => [
                    Rule::unique(User::class),
                ],
                'provider_id' => [
                    Rule::unique(User::class),
                ],
            ])->validate();

            $user = User::create([
                'fname' => $providerUser->fname,
                'lname' => $providerUser->lname,
                'email' => $providerUser->email,
                'avatar' => $providerUser->avatar,
                'provider_id' => $providerUser->provider_id,
            ]);
        }

        return $user;
    }
}