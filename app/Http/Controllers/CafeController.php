<?php

namespace App\Http\Controllers;

use App\Http\Resources\CafeResource;
use App\Models\Cafe;
use App\Models\CafeUser;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return object
     */
    public function index()
    {
        if(request()->query('columns') === 'cafeCardInfo')
        {
            // Passing only columns needed to Resource Cafe
            return CafeResource::collection(Cafe::all('id', 'name'));
        }

        // If no query pass everything except created and updated columns
        return CafeResource::collection(Cafe::all('id', 'name', 'city', 'address', 'email', 'phone'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cafe $cafe
     * @return CafeResource
     */
    public function show($cafeId)
    {
        // Passing only columns needed to show only one cafe
        return new CafeResource(Cafe::select('id', 'name', 'city', 'address', 'email', 'phone')->findOrFail($cafeId));
    }

    public function subscribe($cafeId)
    {
        CafeUser::create([
            'user_id' => auth()->id(),
            'cafe_id' => $cafeId,
        ]);

        return true;
    }

}
