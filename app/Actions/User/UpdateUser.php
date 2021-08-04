<?php

namespace App\Actions\User;

use App\Actions\User\Authentication\CheckIfPasswordMatch;
use Illuminate\Support\Facades\Hash;

class UpdateUser
{
    protected CheckIfPasswordMatch $checkPasswordMatch;

    public function __construct(CheckIfPasswordMatch $checkPasswordMatch)
    {
        $this->checkPasswordMatch = $checkPasswordMatch;
    }

    public function handle(array $validatedData)
    {
        if(array_key_exists('password', $validatedData))
        {
            $this->checkPasswordMatch->handle($validatedData['old_password']);
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        unset($validatedData['old_password']);

        auth()->user()
            ->update($validatedData);
    }
}