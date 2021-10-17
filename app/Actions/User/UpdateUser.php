<?php

namespace App\Actions\User;

use App\Actions\Image\UploadImage;
use App\Actions\User\Authentication\CheckIfPasswordMatch;
use App\Models\User;
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

    public function handle(array $validatedData, User $providedUser = null): void
    {
        $user = $providedUser ?: auth()->user();
        if(array_key_exists('password', $validatedData) && !is_null($validatedData['password']))
        {
            $this->checkPasswordMatch->handle($validatedData['old_password']);
            $validatedData['password'] = Hash::make($validatedData['password']);
        }
        if(array_key_exists('avatar', $validatedData) && !is_null($validatedData['avatar']))
        {
            $avatarName = auth()->id() . '_avatar_' . uniqid();

            $avatar = $this->uploadImage->handle(
                auth()->user(),
                $validatedData['avatar'],
                $avatarName,
                'img/users/',
                85,
                85
            );

            $validatedData['avatar'] = $avatar;
        }

        unset($validatedData['old_password']);

        $user
            ->update($validatedData);
    }
}