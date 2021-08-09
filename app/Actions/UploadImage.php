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
            $image = $avatar->base64String;  // base64 encoded image as string
            $image = str_replace('data:image/' . $avatar->format . ';base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $avatarName = auth()->id() . '.' . $avatar->format;
            File::put(storage_path('img/user') . '/' . $avatarName, base64_decode($image));
        }catch(Exception $ex)
        {
            $avatarName = 'default_avatar.png';
        }

        return $avatarName;
    }
}