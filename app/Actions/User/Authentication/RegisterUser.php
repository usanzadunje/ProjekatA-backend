<?php

namespace App\Actions\User\Authentication;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterUser
{

    public function handle(array $validatedData): array
    {
        $user = User::create([
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        return [
            'token' => $user?->createToken($validatedData['device_name'])->plainTextToken,
        ];
    }
}