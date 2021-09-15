<?php

namespace App\Actions\User\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class CheckIfPasswordMatch
{
    public function handle(string $providedPassword, User $providedUser = null)
    {
        $user = $providedUser ?: auth()->user();
        if(!$user || !Hash::check($providedPassword, $user->password))
        {
            throw ValidationException::withMessages([
                'login' => [
                    trans('auth.again'),
                    trans('auth.failed'),
                ],
            ]);
        }
    }
}