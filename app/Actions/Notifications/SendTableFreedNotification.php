<?php


namespace App\Actions\Notifications;

use App\Models\Cafe;

class SendTableFreedNotification
{
    protected SendNotificationViaFCM $sendNotificationViaFCM;

    public function __construct(SendNotificationViaFCM $sendNotificationViaFCM)
    {
        $this->sendNotificationViaFCM = $sendNotificationViaFCM;
    }

    public function handle(Cafe $place): void
    {
        $tokens = $place->subscribedUsers()
            ->pluck('fcm_token')
            ->toArray();

        $body = "There is a free spot in $place->name now";

        if(!empty($tokens))
        {
            $this->sendNotificationViaFCM->handle($tokens, 'Table freed', $body);
        }
    }
}
