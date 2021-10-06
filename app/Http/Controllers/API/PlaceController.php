<?php

namespace App\Http\Controllers\API;

use App\Actions\Image\RemoveImage;
use App\Actions\Image\SetImageAsMain;
use App\Actions\Owner\Place\UpdatePlaceInfo;
use App\Actions\Owner\Place\UploadPlaceImages;
use App\Actions\Place\TakeChunkedPlaces;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Requests\UploadPlaceImagesRequest;
use App\Http\Resources\CafeResource;
use App\Http\Resources\ImageResource;
use App\Models\Cafe;
use App\Models\Image;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\UnauthorizedException;

class PlaceController extends Controller
{
    public function index(TakeChunkedPlaces $takeChunkedPlaces): ResourceCollection
    {
        $places = $takeChunkedPlaces->handle();

        // Passing only columns needed to Resource Cafe
        return CafeResource::collection($places);
    }

    public function show(int $placeId): CafeResource
    {
        // Passing only columns needed to show only one place
        return new CafeResource(
            Cafe::with('images')
                ->withCount([
                    'tables',
                    'tables as taken_tables_count' => function(Builder $query) {
                        $query->where('empty', false);
                    },
                ])
                ->findOrFail(
                    $placeId,
                    ['id', 'name', 'city', 'address', 'email', 'phone', 'latitude', 'longitude', 'mon_fri', 'saturday', 'sunday']
                )
        );
    }

    public function update(UpdatePlaceRequest $request, UpdatePlaceInfo $updatePlaceInfo): void
    {
        try
        {
            $updatePlaceInfo->handle($request->validated());
        }catch(UnauthorizedException $e)
        {
            abort(403, 'Unauthorized.');
        }
    }

    public function availability(): JsonResponse
    {
        $place = Cafe::select('id')
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->where('id', auth()->user()->cafe)
            ->firstOr(function() {
                abort(403);
            });

        $data = ['availability_ratio' => $place->takenMaxCapacityTableRatio()];

        return response()->success('Successfully fetched place availability!', $data);
    }

    public function images(Cafe $place): ResourceCollection
    {
        return ImageResource::collection($place->images()->select('path', 'is_main')->get());
    }

    public function workingHours(Cafe $place): JsonResponse
    {
        return response()->json([
            'mon_fri' => $place->mon_fri,
            'saturday' => $place->saturday,
            'sunday' => $place->sunday,
        ]);
    }

    public function imageUpload(UploadPlaceImagesRequest $request, UploadPlaceImages $uploadPlaceImages): void
    {
        $place = auth()->user()->ownerCafes;

        $uploadPlaceImages->handle($request->validated(), $place);
    }

    public function imageSetMain(Image $image, SetImageAsMain $setImageAsMain): void
    {
        $placeId = auth()->user()->isOwner();

        $setImageAsMain->handle($image, $placeId);
    }

    public function imageDestroy(Image $image, RemoveImage $removeImage): void
    {
        $removeImage->handle($image);
    }
}
