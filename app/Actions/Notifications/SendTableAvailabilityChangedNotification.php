<?php


namespace App\Actions\Notifications;

use App\Models\User;

class SendTableAvailabilityChangedNotification
{
    protected SendNotificationViaFCM $sendNotificationViaFCM;

    public function __construct(SendNotificationViaFCM $sendNotificationViaFCM)
    {
        $this->sendNotificationViaFCM = $sendNotificationViaFCM;
    }

    public function handle(int $placeId): void
    {
        $tokens = User::select('fcm_token')
            ->whereNotNull('fcm_token')
            ->where('cafe', $placeId)
            ->pluck('fcm_token')
            ->toArray();

        if(!empty($tokens))
        {
            $this->sendNotificationViaFCM->handle($tokens, 'Changed');
        }
    }
}