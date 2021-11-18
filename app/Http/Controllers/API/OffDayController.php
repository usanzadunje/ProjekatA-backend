<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOffDayRequest;
use App\Http\Requests\UpdateOffDayRequest;
use App\Http\Resources\OffDayResource;
use App\Models\OffDay;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class OffDayController extends Controller
{
    public function index(): ResourceCollection
    {
        return OffDayResource::collection(
            auth()
                ->user()
                ->dayOffRequests()
                ->select('id', 'start_date', 'number_of_days', 'status', 'message')
                ->get()
        );
    }

    public function store(StoreOffDayRequest $request): OffDayResource
    {
        $validatedData = $request->validated();

        $createdOffDay = auth()
            ->user()
            ->dayOffRequests()
            ->create($validatedData);

        return new OffDayResource(
            $createdOffDay->unsetRelation('user')
        );
    }

    public function update(OffDay $offDay, UpdateOffDayRequest $request): JsonResponse
    {
        $offDay->update(
            array_merge(
                $request->validated(),
                ['status' => 0]
            )
        );

        $endDate = $offDay->start_date->addDays($offDay->number_of_days - 1);

        return response()->success('Success update.', [
            'end_date' => "{$endDate->day}-{$endDate->month}-{$endDate->year}",
        ]);
    }

    public function indexByPlace(): ResourceCollection
    {
        return OffDayResource::collection(
            auth()
                ->user()
                ->allDayOffRequestsForPlace()
        );
    }

    public function statuses(): ResourceCollection
    {
        return OffDayResource::collection(
            auth()
                ->user()
                ->dayOffRequests()
                ->select('id', 'status')
                ->get()
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
