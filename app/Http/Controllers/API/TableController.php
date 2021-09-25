<?php

namespace App\Http\Controllers\API;

use App\Actions\Place\Table\ToggleTableAvailability;
use App\Http\Controllers\Controller;
use App\Http\Resources\CafeResource;
use App\Http\Resources\TableResource;
use App\Models\Cafe;
use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;

class TableController extends Controller
{

    public function index(Cafe $cafe)
    {
        return new CafeResource($cafe->load('tables'));
    }

    public function show(Cafe $cafe, $serialNumber)
    {
        return new TableResource($cafe->getTableWithSerialNumber($serialNumber));
    }

    //Eventually logic will be switched to this when there will be shown all off tables and specific table
    // would be managable from frontend
    //public function toggle(Table $table): JsonResponse
    //{
    //    $table->toggleAvailability();
    //
    //    return response()->success('Successfully changed place availability!');
    //}

    public function toggle($available, ToggleTableAvailability $toggleTableAvailability): JsonResponse
    {
        $data = [];
        try
        {
            $data = $toggleTableAvailability->handle($available, auth()->user());
        }catch(UnauthorizedException $e)
        {
            abort(403);
        }

        return response()->success('Successfully changed place availability!', $data);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }


    public function edit(Table $table)
    {
        //
    }

    public function destroy(Table $table)
    {
        //
    }
}
