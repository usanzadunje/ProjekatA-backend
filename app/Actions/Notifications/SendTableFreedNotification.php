<?php


namespace App\Actions\Notifications;

class SendTableFreedNotification
{
    protected SendDataNotificationViaFCM $sendDataNotificationViaFCM;

    public function __construct(SendDataNotificationViaFCM $sendDataNotificationViaFCM)
    {
        $this->sendDataNotificationViaFCM = $sendDataNotificationViaFCM;
    }

    public function handle($place): void
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
            $this->sendDataNotificationViaFCM->handle(
                $tokens,
                [
                    'type' => 'notification',
                    'title' => $title,
                    'body' => $body,
                    'id' => abs(crc32(uniqid())),
                    'place_name' => $place->name,
                ]
            );
        }
    }
}
