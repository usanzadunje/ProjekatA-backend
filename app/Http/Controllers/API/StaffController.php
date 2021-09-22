<?php

namespace App\Http\Controllers\API;

use App\Actions\Place\Table\ToggleTableAvailability;
use App\Http\Controllers\Controller;
use App\Http\Requests\ToggleActivityStaffRequest;
use App\Models\Cafe;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\UnauthorizedException;

class StaffController extends Controller
{
    public function toggleActivity(ToggleActivityStaffRequest $request)
    {
        $validatedData = $request->validated();

        auth()->user()->update([
            'active' => $validatedData['active'],
        ]);

        return response()->success('Successfully reported your activity status!');
    }

    public function inactive(): JsonResponse
    {
        auth()->user()->update([
            'active' => false,
        ]);

        return response()->success('Successfully reported yourself as inactive!');
    }

    public function availability(): JsonResponse
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

    public function toggleTableAvailability($available, ToggleTableAvailability $toggleTableAvailability): JsonResponse
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
}
