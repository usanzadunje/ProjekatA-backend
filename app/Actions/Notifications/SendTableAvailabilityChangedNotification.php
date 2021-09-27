<?php


namespace App\Actions\Notifications;

use App\Models\User;

class SendTableAvailabilityChangedNotification
{
    protected SendDataNotificationViaFCM $sendDataNotificationViaFCM;

    public function __construct(SendDataNotificationViaFCM $sendDataNotificationViaFCM)
    {
        $this->sendDataNotificationViaFCM = $sendDataNotificationViaFCM;
    }

    public function handle($place): void
    {
        $tokens = User::select('fcm_token')
            ->whereNotNull('fcm_token')
            ->where('cafe', $place->id)
            ->orWhere('id', $place->user_id)
            ->where('id', '!=', auth()->id())
            ->pluck('fcm_token')
            ->toArray();

        if(!empty($tokens))
        {
            $this->sendDataNotificationViaFCM->handle(
                $tokens,
                [
                    'type' => 'availabilityChanged',
                    'availability_ratio' => $place->takenMaxCapacityTableRatio(),
                ]
            );
        }
    }
}