<?php

namespace App\Observers;

use App\Actions\Notifications\SendScheduleAddedNotification;
use App\Actions\Notifications\SendScheduleRemovedNotification;
use App\Actions\Notifications\SendScheduleUpdatedNotification;
use App\Models\Schedule;

class ScheduleObserver
{
    public function __construct(
        protected SendScheduleAddedNotification $sendScheduleAddedNotification,
        protected SendScheduleUpdatedNotification $sendScheduleUpdatedNotification,
        protected SendScheduleRemovedNotification $sendScheduleRemovedNotification,
    )
    {
    }

    public function created(Schedule $schedule)
    {
        $this->sendScheduleAddedNotification->handle($schedule);
    }

    public function updated(Schedule $schedule)
    {
        if(
            $schedule->start_time !== $schedule->getOriginal('start_time') ||
            $schedule->number_of_hours !== $schedule->getOriginal('number_of_hours')
        ) {
            $this->sendScheduleUpdatedNotification->handle($schedule);
        }
    }


    public function deleted(Schedule $schedule)
    {
        $this->sendScheduleRemovedNotification->handle($schedule);
    }
}
