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

        $title = trans('notifications.free_spot') . '!';

        $body = trans(
            'notifications.free_spot_body',
            ['place' => $place->name]
        );

        if(!empty($tokens))
        {
            $this->sendNotificationViaFCM->handle(
                $tokens,
                $title,
                $body,
                'default',
                [
                    'type' => 'notification',
                    'place_name' => $place->name,
                ]
            );
        }
    }
}
