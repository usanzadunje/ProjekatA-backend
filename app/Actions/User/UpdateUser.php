<?php

namespace App\Actions\User;

use App\Actions\UploadImage;
use App\Actions\User\Authentication\CheckIfPasswordMatch;
use Illuminate\Support\Facades\Hash;

class UpdateUser
{
    protected CheckIfPasswordMatch $checkPasswordMatch;
    protected UploadImage $uploadImage;

    public function __construct(CheckIfPasswordMatch $checkPasswordMatch, UploadImage $uploadImage)
    {
        $this->checkPasswordMatch = $checkPasswordMatch;
        $this->uploadImage = $uploadImage;
    }

    public function handle(array $validatedData)
    {
        if(array_key_exists('password', $validatedData))
        {
            $this->checkPasswordMatch->handle($validatedData['old_password']);
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if(array_key_exists('avatar', $validatedData))
        {
            $avatar = $this->uploadImage->handle($validatedData['avatar']);
            $validatedData['avatar'] = $avatar;
        }
        unset($validatedData['old_password']);

        auth()->user()
            ->update($validatedData);
    }
}