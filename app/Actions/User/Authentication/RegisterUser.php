<?php

namespace App\Actions\User\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterUser
{

    public function handle(array $validatedData): string
    {
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        if(!$user)
        {
            throw ValidationException::withMessages([
                'registration' => ['Something went wrong. Try again later.'],
            ]);
        }

        return $user->createToken($validatedData['device_name'])->plainTextToken;
    }
}