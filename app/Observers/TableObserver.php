<?php

namespace App\Observers;

use App\Actions\Notifications\SendTableAvailabilityChangedNotification;
use App\Actions\Notifications\SendTableFreedNotification;
use App\Models\Table;

class TableObserver
{
    protected SendTableFreedNotification $sendTableFreedNotification;
    protected SendTableAvailabilityChangedNotification $availabilityChangedNotification;

    public function __construct(
        SendTableFreedNotification $sendTableFreedNotification,
        SendTableAvailabilityChangedNotification $availabilityChangedNotification
    )
    {
        $this->sendTableFreedNotification = $sendTableFreedNotification;
        $this->availabilityChangedNotification = $availabilityChangedNotification;
    }

    public function created(Table $table)
    {
        //
    }

    public function updated(Table $table)
    {
        $place = $table->cafe;

        if($place->isFull())
        {
            // Notify all subscribed users that table has been freed in cafe
            $this->sendTableFreedNotification->handle($place);
        }

        // Notify all staff for place that availability has changed
        // so app can update it's state
        $this->availabilityChangedNotification->handle($place->id);
    }


    public function deleted(Table $table)
    {
        //
    }
}
