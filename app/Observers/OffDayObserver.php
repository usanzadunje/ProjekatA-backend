<?php

namespace App\Observers;

use App\Actions\Notifications\SendOwnerOffDayDecisionNotification;
use App\Actions\Notifications\SendStaffRequestedDayOffNotification;
use App\Models\OffDay;

class OffDayObserver
{
    public function __construct(
        protected SendOwnerOffDayDecisionNotification $sendOwnerOffDayDecisionNotification,
        protected SendStaffRequestedDayOffNotification $sendStaffRequestedDayOffNotification,
    )
    {
    }

    public function created(OffDay $offDay)
    {
        $this->sendStaffRequestedDayOffNotification->handle($offDay);
    }

    public function updated(OffDay $offDay)
    {
        if($offDay->status !== $offDay->getOriginal('status'))
        {
            $this->sendOwnerOffDayDecisionNotification->handle($offDay);
        }
    }


    public function deleted(OffDay $offDay)
    {
        //
    }
}
