<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Table;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    public function availability()
    {
        $place = Cafe::select('id')->where('id', auth()->user()->cafe)->firstOr(function() {
            abort(403);
        });

        $data = ['availability_ratio' => $place->takenMaxCapacityTableRatio()];

        return response()->success('Successfully fetched place availability!', $data);
    }

    //Eventually logic will be switched to this when there will be shown all off tables and specific table
    // would be managable from frontend
    //public function toggle(Table $table): JsonResponse
    //{
    //    $table->toggleAvailability();
    //
    //    return response()->success('Successfully changed place availability!');
    //}

    public function toggle($available): JsonResponse
    {
        $place = Cafe::select('id')->where('id', auth()->user()->cafe)->firstOr(function() {
            abort(403);
        });

        $table = Table::where('cafe_id', $place->id)->available(!($available === 'true'))->first();

        if($table)
        {
            $table->toggleAvailability();
        }

        $data = ['availability_ratio' => $place->takenMaxCapacityTableRatio()];

        return response()->success('Successfully changed place availability!', $data);
    }
}
