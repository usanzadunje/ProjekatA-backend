<?php

namespace App\Actions\Owner\Place;


use App\Models\Cafe;

class UploadPlaceImages
{
    public function handle(array $validatedData, Cafe $place): void
    {
        foreach($validatedData['images'] as $image)
        {
            $path = $image->store("img/places/$place->name", 'public');

            // img folder is already predefined on frontend so it is unnecessary here
            // therefore it is excluded from the path
            $place->images()->create([
                'path' => str_replace('img', '', $path),
            ]);
        }
    }
}