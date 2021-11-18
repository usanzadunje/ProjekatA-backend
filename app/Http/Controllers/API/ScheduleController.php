<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use App\Http\Resources\ScheduleResource;
use App\Models\Schedule;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ScheduleController extends Controller
{
    public function index(): ResourceCollection
    {
        return ScheduleResource::collection(
            auth()
                ->user()
                ->schedules()
                ->select('id', 'start_date', 'start_time', 'number_of_hours')
                ->get()
        );
    }

    public function indexByPlace(): ResourceCollection
    {
        return ScheduleResource::collection(
            auth()
                ->user()
                ->allSchedulesForPlace()
        );
    }

    public function store(StoreScheduleRequest $request): ScheduleResource
    {
        $createdSchedule = Schedule::create($request->validated());

        return new ScheduleResource(
            $createdSchedule->load(['user' => function($query) {
                $query->select('id', 'fname', 'lname', 'username');
            }])
        );
    }

    public function update(Schedule $schedule, UpdateScheduleRequest $request): void
    {
        $schedule->update($request->validated());
    }

    public function destroy(Schedule $schedule): void
    {
        $schedule->delete();
    }
}
