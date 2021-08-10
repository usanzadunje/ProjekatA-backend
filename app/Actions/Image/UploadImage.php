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
        if(!str_contains($dataUrl, 'image/jpeg'))
        {
            throw ValidationException::withMessages([
                'avatar' => [trans('validation.custom-image')],
            ]);
        }
        try
        {
            if($height && $width)
            {
                $dataUrl = (string)Image::make($dataUrl)
                    ->fit($width, $height, function($constraint) {
                        $constraint->upsize();
                    })
                    ->encode('data-url', 100);
            }
	    $format = str_contains('png', $dataUrl) ? 'png' : 
'jpeg';


            $base64String = 
str_replace("data:image/" . $format .";base64,", '', $dataUrl);

            $avatar = base64_decode($base64String);


            $avatarName = auth()->id() . '_avatar.' . $format;

            Storage::disk('public')->put('img/user/' . $avatarName, $avatar);

        }catch(Exception $ex)
        {
            $avatarName = auth()->user()->avatar ?? 'default_avatar.png';
        }

        return $avatarName;
    }
}
