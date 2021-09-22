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

    public function handle(int $placeId): void
    {
        $tokens = User::select('fcm_token')
            ->whereNotNull('fcm_token')
            ->where('cafe', $placeId)
            ->where('id', '!=', auth()->id())
            ->pluck('fcm_token')
            ->toArray();

        if(!empty($tokens))
        {
            $this->sendDataNotificationViaFCM->handle(
                $tokens,
                ['type' => 'availabilityChanged']
            );
        }
    }
}