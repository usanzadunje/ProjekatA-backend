<?php

namespace App\Observers;

use App\Actions\Notifications\SendTableAvailabilityChangedNotification;
use App\Actions\Notifications\SendTableFreedNotification;
use App\Models\Table;

class TableObserver
{
    public function created(Table $table)
    {
        //
    }

    public function updated(
        Table $table,
        SendTableFreedNotification $sendTableFreedNotification,
        SendTableAvailabilityChangedNotification $availabilityChangedNotification
    )
    {
        $place = $table->cafe;

        if($place->isFull())
        {
            // Notify all subscribed users that table has been freed in cafe
            $sendTableFreedNotification->handle($place);
        }

        // Notify all staff for place that availability has changed
        // so app can update it's state
        $availabilityChangedNotification->handle($place->id);
    }


    public function deleted(Table $table)
    {
        //
    }
}
