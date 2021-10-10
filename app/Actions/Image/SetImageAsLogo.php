<?php

namespace App\Actions\Image;

use App\Models\Image;

class SetImageAsLogo
{

    public function handle(Image $image, int $placeId)
    {
        Image::where('is_logo', true)
            ->where('imagable_id', $placeId)
            ->update([
                'is_logo' => false,
            ]);

        $image->update([
            'is_logo' => true,
        ]);
    }
}
