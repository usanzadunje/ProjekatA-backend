<?php

namespace App\Observers;

use App\Actions\Notifications\SendTableAvailabilityChangedNotification;
use App\Actions\Notifications\SendTableFreedNotification;
use App\Models\Table;
use Illuminate\Database\Eloquent\Builder;

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
        $place = $table->cafe()
            ->withCount([
                'tables',
                'tables as taken_tables_count' => function(Builder $query) {
                    $query->where('empty', false);
                },
            ])
            ->first();

        /*
         * Since table availability is firstly changed and then this event triggers
         * we cannot check if table is full because it will only send notification when place is full
         * we want to send notification when place was full then one table was freed
         * this means free table count will be one
         * Using isFull() on place will result in sending notification when actual
         * place availability is full (WHICH IS NOT THE GOAL OF THIS NOTIFICATION!)
         */
        if($place->freeTablesCount() === 1 && $table->empty)
        {
            // Notify all subscribed users that table has been freed in cafe
            $this->sendTableFreedNotification->handle($place);
        }

        // Notify all staff for place that availability has changed
        // so app can update it's state
        $this->availabilityChangedNotification->handle($place, $place->takenMaxCapacityTableRatio());
    }


    public function deleted(Table $table)
    {
        //
    }
}
