<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Place\UpdatePlaceInfo;
use App\Actions\Place\TakeChunkedPlaces;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePlaceRequest;
use App\Http\Resources\PlaceResource;
use App\Http\Resources\ImageResource;
use App\Models\Place;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\UnauthorizedException;

class PlaceController extends Controller
{
    public function index(TakeChunkedPlaces $takeChunkedPlaces): ResourceCollection
    {
        $getAllColumns = request('getAllColumns') === 'true';
        $sortBy = request('sortBy') ?: 'default';

        $places = $takeChunkedPlaces->handle(
            $getAllColumns,
            $sortBy,
            request('filter'),
            request('offset'),
            request('limit')
        );

        // Passing only columns needed to Resource Place
        return PlaceResource::collection($places);
    }

    public function show(int $placeId): PlaceResource
    {
        $showScreen = \request()->query('showScreen');

        $basicColumns = ['id', 'name', 'city', 'address', 'email', 'phone', 'latitude', 'longitude'];
        $workHoursColumns = ['mon_fri', 'saturday', 'sunday'];

        $columns = $showScreen
            ? $basicColumns
            : array_merge($basicColumns, $workHoursColumns);

        return new PlaceResource(
            Place::select($columns)
                ->when(
                    $showScreen,
                    function(Builder $query) {
                        $query->with('tables.section');
                    },
                    function(Builder $query) {
                        $query->with('images');
                    }
                )
                ->with('sections')
                ->withCount([
                    'tables',
                    'tables as taken_tables_count' => function(Builder $query) {
                        $query->where('empty', false);
                    },
                ])
                ->findOrFail($placeId)
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
        $place = Place::select('id')
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->where('id', auth()->user()->place)
            ->firstOr(function() {
                abort(403);
            });

        $data = ['availability_ratio' => $place->takenMaxCapacityTableRatio()];

        return response()->success('Successfully fetched place availability!', $data);
    }

    public function images(Place $place): ResourceCollection
    {
        return ImageResource::collection($place->images()->select('path', 'is_main', 'is_logo')->get());
    }

    public function workingHours(Place $place): JsonResponse
    {
        return response()->json([
            'mon_fri' => $place->mon_fri,
            'saturday' => $place->saturday,
            'sunday' => $place->sunday,
        ]);
    }
}
