<?php

namespace App\Actions\Image;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadImage
{

    public function handle(User $providedUser, string $dataUrl, string $imageName, string $publicPath, $width = null, $height = null): string
    {
        try
        {
            $user = $providedUser ?? auth()->user();

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

            $avatarName = $imageName . '.' . $format;

            Storage::disk('public')->put($publicPath . $avatarName, $avatar);

            if($user->avatar !== 'default_avatar.png')
            {
                Storage::disk('public')->delete($publicPath . $user->avatar);
            }
        }catch(Exception $ex)
        {
            $avatarName = 'default_avatar.png';
        }

        return $avatarName;
    }
}
