<?php

namespace App\Actions\User\Authentication;

use App\Models\User;

class LoginUser
{
    protected CheckIfPasswordMatch $checkPasswordMatch;

    public function __construct(CheckIfPasswordMatch $checkPasswordMatch)
    {
        $this->checkPasswordMatch = $checkPasswordMatch;
    }

    public function handle(array $validatedData): User
    {
        $user = User::where('email', $validatedData['email'])->first();

        $this->checkPasswordMatch->handle($validatedData['password'], $user);

        return $user->createToken($validatedData['device_name'])->plainTextToken;
    }
}