<?php

namespace App\Http\Controllers\API;

use App\Actions\Image\RemoveImage;
use App\Actions\Image\SetImageAsLogo;
use App\Actions\Image\SetImageAsMain;
use App\Actions\Owner\Place\UploadPlaceImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadPlaceImagesRequest;
use App\Models\Image;

class ImageController extends Controller
{
    public function store(UploadPlaceImagesRequest $request, UploadPlaceImages $uploadPlaceImages): void
    {
        $place = auth()->user()->ownerCafes;

        $uploadPlaceImages->handle($request->validated(), $place);
    }

    public function destroy(Image $image, RemoveImage $removeImage): void
    {
        $removeImage->handle($image);
    }

    public function main(Image $image, SetImageAsMain $setImageAsMain): void
    {
        $placeId = auth()->user()->isOwner();

        $setImageAsMain->handle($image, $placeId);
    }

    public function logo(Image $image, SetImageAsLogo $setImageAsLogo): void
    {
        $placeId = auth()->user()->isOwner();

        $setImageAsLogo->handle($image, $placeId);
    }
}
