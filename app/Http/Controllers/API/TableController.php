<?php

namespace App\Http\Controllers\API;

use App\Actions\Owner\Tables\StoreOrUpdateTables;
use App\Actions\Place\Table\ToggleTableAvailability;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOrUpdateTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Http\Resources\TableResource;
use App\Models\Place;
use App\Models\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Validation\UnauthorizedException;

class TableController extends Controller
{

    public function index($placeId = null): ResourceCollection
    {
        $providedPlaceId = $placeId ?: auth()->user()->isStaff();

        return TableResource::collection(
            Table::select('id', 'empty', 'smoking_allowed', 'top', 'left', 'place_id')
                ->where('place_id', $providedPlaceId)
                ->get()
        );
    }

    public function show(Place $place, $serialNumber): TableResource
    {
        return new TableResource($place->getTableWithSerialNumber($serialNumber));
    }

    //Eventually logic will be switched to this when there will be shown all off tables and specific table
    // would be managable from frontend
    public function toggle(Table $table): JsonResponse
    {
        $table->toggleAvailability();

        $place = $table
            ->place()
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->first();

        return response()->success('Successfully changed place availability!', [
            'availability_ratio' => $place->takenMaxCapacityTableRatio(),
        ]);
    }

    public function randomToggle($available, ToggleTableAvailability $toggleTableAvailability): JsonResponse
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

    public function storeOrUpdate(StoreOrUpdateTableRequest $request, StoreOrUpdateTables $storeOrUpdateTables): ResourceCollection
    {
        $createdTables = $storeOrUpdateTables->handle($request->validated(), auth()->user());

        return TableResource::collection($createdTables);
    }

    public function update(Table $table, UpdateTableRequest $updateTableRequest)
    {
        $table->update($updateTableRequest->validated());
    }

    public function destroy(Table $table): void
    {
        $table->delete();
    }
}
