<?php


namespace App\Actions\Notifications;

use App\Models\Table;

class SendTableFreedNotification
{
    protected SendDataNotificationViaFCM $sendDataNotificationViaFCM;

    public function __construct(SendDataNotificationViaFCM $sendDataNotificationViaFCM)
    {
        $this->sendDataNotificationViaFCM = $sendDataNotificationViaFCM;
    }

    public function handle($place, Table $table): void
    {
        $tokens = $place->subscribedUsers()
            ->pluck('fcm_token')
            ->toArray();

        if(!empty($tokens))
        {
            $this->sendDataNotificationViaFCM->handle(
                $tokens,
                [
                    'type' => 'notification',
                    'id' => abs(crc32(uniqid())),
                    'place_name' => $place->name,
                    'seats' => $table->seats,
                ]
            );
        }
    }
}
