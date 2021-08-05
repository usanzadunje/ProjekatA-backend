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

    public function handle(array $validatedData): string
    {
        $login = $validatedData['login'];
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $login)->first();

        $this->checkPasswordMatch->handle($validatedData['password'], $user);

        return $user->createToken($validatedData['device_name'])->plainTextToken;
    }
}