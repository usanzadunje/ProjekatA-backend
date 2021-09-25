<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Place\UpdatePlaceInfo;
use App\Actions\Owner\Place\UploadPlaceImages;
use App\Actions\Place\TakeChunkedPlaces;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Requests\UploadPlaceImagesRequest;
use App\Http\Resources\CafeResource;
use App\Models\Cafe;
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

    public function show(int $cafeId): CafeResource
    {
        // Passing only columns needed to show only one cafe
        return new CafeResource(
            Cafe::with('offerings')
                ->with('images')
                ->findOrFail(
                    $cafeId,
                    ['id', 'name', 'city', 'address', 'email', 'phone', 'latitude', 'longitude']
                )
        );
    }

    public function update(UpdatePlaceRequest $request, UpdatePlaceInfo $updatePlaceInfo): JsonResponse
    {
        try
        {
            $updatePlaceInfo->handle($request->validated());
        }catch(UnauthorizedException $e)
        {
            abort(403, 'Unauthorized.');
        }

        return \response()->success('Successfully updates place information.');
    }

    public function upload(UploadPlaceImagesRequest $request, UploadPlaceImages $uploadPlaceImages): JsonResponse
    {
        $place = auth()->user()->ownerCafes;

        $uploadPlaceImages->handle($request->validated(), $place);

        return \response()->success('Successfully uploaded place images.');
    }

    public function availability(): JsonResponse
    {
        $place = Cafe::select('id')->where('id', auth()->user()->cafe)->firstOr(function() {
            abort(403);
        });

        $data = ['availability_ratio' => $place->takenMaxCapacityTableRatio()];

        return response()->success('Successfully fetched place availability!', $data);
    }

}
