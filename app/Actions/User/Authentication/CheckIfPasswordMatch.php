<?php

namespace App\Actions\User\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CheckIfPasswordMatch {

    public function handle(User $user, string $providedPassword)
    {
        if(!$user || !Hash::check($providedPassword, $user->password))
        {
            throw ValidationException::withMessages([
                'email' => [trans('auth.failed')],
                'password' => [trans('auth.again')],
            ]);
        }
    }
}