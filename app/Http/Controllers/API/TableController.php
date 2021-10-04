<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Tables\StoreOrUpdateTables;
use App\Actions\Place\Table\ToggleTableAvailability;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Cafe;
use App\Models\Table;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\UnauthorizedException;

class TableController extends Controller
{

    public function index($placeId = null): ResourceCollection
    {
        $providedPlaceId = $placeId ?: auth()->user()->isOwner();

        return TableResource::collection(
            Table::select('id', 'empty', 'smoking_allowed', 'top', 'left', 'cafe_id')
                ->where('cafe_id', $providedPlaceId)
                ->get()
        );
    }

    public function show(Cafe $cafe, $serialNumber): TableResource
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

    public function storeOrUpdate(StoreOrUpdateTableRequest $request, StoreOrUpdateTables $storeOrUpdateTables): void
    {
        $storeOrUpdateTables->handle($request->validated(), auth()->user());
    }


    public function destroy(Table $table)
    {
        //
    }
}
