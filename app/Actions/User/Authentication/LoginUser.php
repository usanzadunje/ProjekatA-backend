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

    public function handle(array $validatedData): array
    {
        $login = $validatedData['login'];
        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $user = User::where($fieldType, $login)->firstOrFail();

        $this->checkPasswordMatch->handle($validatedData['password'], $user);

        $userInfo = [
            'token' => $user->createToken($validatedData['device_name'])->plainTextToken,
        ];

        $userInfo['role'] = $user->isOwner() ?
            1 : ($user->isStaff() ? 2 : null);

        return $userInfo;
    }
}