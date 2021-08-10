<?php

namespace App\Actions;

use Exception;
use Illuminate\Support\Facades\Storage;

class UploadImage
{

    public function handle(string $dataUrl): string
    {
        try
        {
            $base64String = str_replace("data:image/jpeg;base64,", '', $dataUrl);

            $avatar = base64_decode($base64String);

            $avatarName = auth()->id() . '_avatar.jpeg';

            Storage::disk('public')->put('img/user/' . $avatarName, $avatar);
        }catch(Exception $ex)
        {
            $avatarName = 'default_avatar.png';
        }

        return $avatarName;
    }
}