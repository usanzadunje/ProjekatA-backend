<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOffDayRequest;
use App\Http\Resources\OffDayResource;
use App\Models\OffDay;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OffDayController extends Controller
{
    public function index(): ResourceCollection
    {
        return OffDayResource::collection(
            auth()
                ->user()
                ->dayOffRequests()
                ->select('start_date', 'number_of_days', 'status')
                ->get()
        );
    }

    public function store(StoreOffDayRequest $request): void
    {
        $validatedData = $request->validated();

        auth()
            ->user()
            ->dayOffRequests()
            ->create($validatedData);

    }

    public function indexByPlace(): ResourceCollection
    {
        return OffDayResource::collection(
            auth()
                ->user()
                ->allDayOffRequestsForPlace()
        );
    }

    public function approve(OffDay $offDay): void
    {
        $offDay->update([
            'status' => OffDay::APPROVED,
        ]);
    }

    public function decline(OffDay $offDay): void
    {
        $offDay->update([
            'status' => OffDay::DECLINED,
        ]);
    }
}
