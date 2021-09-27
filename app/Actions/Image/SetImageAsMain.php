<?php

namespace App\Actions\Image;

use App\Models\Image;

class SetImageAsMain
{

    public function handle(Image $image, int $placeId)
    {
        Image::where('is_main', true)
            ->where('cafe_id', $placeId)
            ->update([
                'is_main' => false,
            ]);

        $image->update([
            'is_main' => true,
        ]);
    }
}
