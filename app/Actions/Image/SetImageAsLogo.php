<?php

namespace App\Actions\Image;

use App\Models\Image;

class SetImageAsLogo
{

    public function handle(Image $image)
    {
        Image::where('is_logo', true)
            ->where('imagable_id', $image->imagable_id)
            ->where('imagable_type', $image->imagable_type)
            ->update([
                'is_logo' => false,
            ]);

        $image->update([
            'is_logo' => true,
        ]);
    }
}
