<?php

namespace App\Http\Controllers;

use App\Http\Resources\CafeResource;
use App\Models\Cafe;
use App\Models\CafeUser;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Resource_;

class CafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return ResourceCollection
     */
    public function index()
    {
        // Return everything except created and updated columns
        return CafeResource::collection(Cafe::all('id', 'name', 'city', 'address', 'email', 'phone'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param integer $start
     * @param integer $numberOfCafes
     * @return ResourceCollection | string
     */
    public function chunkedIndex($start = 0, $numberOfCafes = 20)
    {
        $filter = request('filter') ??  '';
        $sortBy = request('sortBy') ?? 'name';

        // Returning false if there are no records to be returned
        // in order to disable infinite scroll on frontend
        if(count(Cafe::takeChunks($start, $numberOfCafes)) <= 0)
            return json_encode(false);

        // Passing only columns needed to Resource Cafe
        else return CafeResource::collection(Cafe::takeChunks($start, $numberOfCafes, $filter, $sortBy));
    }

    /**
     * Display the specified resource.
     *
     * @param integer $cafeId
     * @return CafeResource
     */
    public function show($cafeId)
    {
        // Passing only columns needed to show only one cafe
        return new CafeResource(Cafe::select('id', 'name', 'city', 'address', 'email', 'phone')->findOrFail($cafeId));
    }

    /**
     * Subscribing to specific cafe
     *
     * @param integer $cafeId
     * @return boolean
     */
    public function subscribe($cafeId)
    {
        CafeUser::create([
            'user_id' => auth()->id(),
            'cafe_id' => $cafeId,
        ]);

        return true;
    }

}
