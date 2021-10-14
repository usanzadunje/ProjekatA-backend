<?php

namespace App\Actions\Owner\Place;

class UploadPlaceImages
{
    public function handle(array $validatedData, $model, $storePath): array
    {
        $created = [];
        foreach($validatedData['images'] as $image)
        {
            $path = $image->store("img/$storePath", 'public');

            // img folder is already predefined on frontend so it is unnecessary here
            // therefore it is excluded from the path
            array_push(
                $created,
                $model->images()->create([
                    'path' => str_replace('img', '', $path),
                ])
            );
        }

        return $created;
    }
}