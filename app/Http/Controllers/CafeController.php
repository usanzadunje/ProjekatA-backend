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
        return CafeResource::collection(Cafe::all());
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cafe $cafe
     * @return CafeResource
     */
    public function show(Cafe $cafe)
    {
        return new CafeResource($cafe->load('tables'));
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
