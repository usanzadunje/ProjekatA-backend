<?php

namespace App\Http\Controllers;

use App\Http\Resources\CafeResource;
use App\Models\Cafe;
use Illuminate\Http\Request;

class CafeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CafeResource::collection(Cafe::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Cafe $cafe
     * @return \Illuminate\Http\Response
     */
    public function show(Cafe $cafe)
    {
        return new CafeResource($cafe->load('tables'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Cafe $cafe
     * @return \Illuminate\Http\Response
     */
    public function edit(Cafe $cafe)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Cafe $cafe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cafe $cafe)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Cafe $cafe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cafe $cafe)
    {
        //
    }
}
