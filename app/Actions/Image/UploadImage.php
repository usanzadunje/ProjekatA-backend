<?php

namespace App\Actions\Image;

use Exception;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class UploadImage
{

    public function handle(string $dataUrl, $width = null, $height = null): string
    {
        try
        {
            $format = explode('/', explode(';base64', $dataUrl)[0])[1];

            if($height && $width)
            {
                $dataUrl = (string)Image::make($dataUrl)
                    ->fit($width, $height, function($constraint) {
                        $constraint->upsize();
                    })
                    ->encode('data-url');
            }

            $base64String = str_replace("data:image/$format;base64,", '', $dataUrl);

            $avatar = base64_decode($base64String);

            $avatarName = auth()->id() . '_avatar.' . $format;

            Storage::disk('public')->put('img/user/' . $avatarName, $avatar);

        }catch(Exception $ex)
        {
            $avatarName = auth()->user()->avatar;
        }

        return $avatarName;
    }
}
