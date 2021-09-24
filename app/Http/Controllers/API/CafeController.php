<?php

namespace App\Http\Controllers\API;

use App\Actions\Place\TakeChunkedPlaces;
use App\Http\Controllers\Controller;
use App\Http\Resources\CafeResource;
use App\Models\Cafe;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CafeController extends Controller
{
    /*
     * Display a listing of the resource.
     *
     * @param int $start
     * @param int $numberOfCafes
     * @return ResourceCollection
     */
    public function index(TakeChunkedPlaces $takeChunkedPlaces): ResourceCollection
    {
        $places = $takeChunkedPlaces->handle();

        // Passing only columns needed to Resource Cafe
        return CafeResource::collection($places);
    }

    /*
     * Display the specified resource.
     *
     * @param int $cafeId
     */
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

}
