<?php

namespace App\Actions;

use Illuminate\Support\Facades\Storage;

class UploadImage
{

    public function handle(array $avatar): string
    {
        $avatarName = auth()->id() . '_avatar.' . $avatar['format'];

        Storage::disk('public')->put('img/user/' . $avatarName, base64_decode($avatar['base64String']));

        return $avatarName;
    }
}