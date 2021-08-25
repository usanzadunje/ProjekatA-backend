<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cafe;
use App\Models\Table;
use Illuminate\Http\JsonResponse;

class StaffController extends Controller
{
    public function availability(): JsonResponse
    {
        $place = Cafe::select('id')->where('id', auth()->user()->cafe)->firstOr(function() {
            abort(403);
        });

        $data = ['availability_ratio' => $place->takenMaxCapacityTableRatio()];

        return response()->success('Successfully fetched place availability!', $data);
    }

    public function toggle(Table $table): JsonResponse
    {
        $table->toggleAvailability();

        return response()->success('Successfully changed place availability!');
    }
}
