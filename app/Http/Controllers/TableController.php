<?php

namespace App\Http\Controllers;

use App\Http\Resources\CafeResource;
use App\Http\Resources\TableResource;
use App\Models\Cafe;
use App\Models\Table;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Cafe $cafe)
    {
        return new CafeResource($cafe->load('tables'));
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
     * @param \App\Models\Table $table
     * @return \Illuminate\Http\Response
     */

    public function show(Cafe $cafe, $serialNumber)
    {
        return new TableResource($cafe->getTableWithSerialNumber($serialNumber));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Table $table
     * @return \Illuminate\Http\Response
     */
    public function edit(Table $table)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Table $table
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Table $table)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Table $table
     * @return \Illuminate\Http\Response
     */
    public function destroy(Table $table)
    {
        //
    }
}
