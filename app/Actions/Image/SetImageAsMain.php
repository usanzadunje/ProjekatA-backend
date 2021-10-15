<?php

namespace App\Actions\Image;

use App\Models\Image;

class SetImageAsMain
{

    public function handle(Image $image)
    {
        Image::where('is_main', true)
            ->where('imagable_id', $image->imagable_id)
            ->where('imagable_type', $image->imagable_type)
            ->update([
                'is_main' => false,
            ]);

        $image->update([
            'is_main' => true,
        ]);
    }
}
