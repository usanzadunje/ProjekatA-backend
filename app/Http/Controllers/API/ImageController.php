<?php

namespace App\Http\Controllers\API;

use App\Actions\Image\RemoveImage;
use App\Actions\Image\SetImageAsLogo;
use App\Actions\Image\SetImageAsMain;
use App\Actions\Owner\Place\UploadPlaceImages;
use App\Http\Controllers\Controller;
use App\Http\Requests\UploadPlaceImagesRequest;
use App\Http\Resources\ImageResource;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImageController extends Controller
{
    public function storeForPlace(UploadPlaceImagesRequest $request, UploadPlaceImages $uploadPlaceImages): ResourceCollection
    {
        $place = auth()->user()->ownerCafes;
        $storePath = "places/$place->name";

        $createdImages = $uploadPlaceImages->handle($request->validated(), $place, $storePath);

        return ImageResource::collection($createdImages);
    }

    public function storeForProduct(Product $product, UploadPlaceImagesRequest $request, UploadPlaceImages $uploadPlaceImages): ResourceCollection
    {
        $storePath = "places/{$product->cafe->name}/products/product-$product->id";

        $createdImages = $uploadPlaceImages->handle($request->validated(), $product, $storePath);

        return ImageResource::collection($createdImages);
    }

    public function destroy(Image $image, RemoveImage $removeImage): void
    {
        $removeImage->handle($image);
    }

    public function main(Image $image, SetImageAsMain $setImageAsMain): void
    {
        $setImageAsMain->handle($image);
    }

    public function logo(Image $image, SetImageAsLogo $setImageAsLogo): void
    {
        $setImageAsLogo->handle($image);
    }
}
