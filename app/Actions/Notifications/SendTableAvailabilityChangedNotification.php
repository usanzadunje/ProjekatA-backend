<?php


namespace App\Actions\Notifications;

use App\Models\Table;
use App\Models\User;

class SendTableAvailabilityChangedNotification
{
    public function __construct(protected SendDataNotificationViaFCM $sendDataNotificationViaFCM)
    {
    }

    public function handle($place, Table $table): void
    {
        $tokens = User::select('fcm_token')
            ->whereNotNull('fcm_token')
            ->where(function($query) use ($place) {
                $query
                    ->where('place', $place->id)
                    ->orWhere('id', $place->user_id);
            })
            ->where('id', '!=', auth()->id())
            ->pluck('fcm_token')
            ->toArray();

        if(!empty($tokens))
        {
            $this->sendDataNotificationViaFCM->handle(
                $tokens,
                [
                    'type' => 'availabilityChanged',
                    'table_id' => $table->id,
                    'empty' => $table->empty,
                    'availability_ratio' => $place->takenMaxCapacityTableRatio(),
                ]
            );
        }
    }
}