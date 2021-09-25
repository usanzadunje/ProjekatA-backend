<?php

namespace App\Actions\Image;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;

class RemoveImage
{
    public function handle(Image $image)
    {
        Storage::disk('public')->delete("img$image->path");

        $image->delete();
    }
}
