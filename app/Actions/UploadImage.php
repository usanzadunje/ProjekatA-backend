<?php

namespace App\Actions;

use Exception;
use Illuminate\Support\Facades\File;

class UploadImage
{

    public function handle(array $avatar): string
    {
        try
        {
            $avatarName = auth()->id() . '_avatar.' . $avatar->format;
            File::put(storage_path('img/user') . '/' . $avatarName, base64_decode($avatar->base64String));
        }catch(Exception $ex)
        {
            $avatarName = 'default_avatar.png';
        }

        return $avatarName;
    }
}