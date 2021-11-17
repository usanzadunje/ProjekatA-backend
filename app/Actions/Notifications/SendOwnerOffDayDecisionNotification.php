<?php


namespace App\Actions\Notifications;

use App\Models\OffDay;

class SendOwnerOffDayDecisionNotification
{
    public function __construct(protected SendDataNotificationViaFCM $sendDataNotificationViaFCM)
    {
    }

    public function handle(OffDay $offDay): void
    {
        $token = $offDay->user->fcm_token;
        if(!empty($token))
        {
            $this->sendDataNotificationViaFCM->handle(
                $token,
                [
                    'type' => 'dayOffStatusChanged',
                    'id' => abs(crc32(uniqid())),
                    'day' => $offDay->start_date->day,
                    'month' => $offDay->start_date->month,
                    'year' => $offDay->start_date->year,
                    'number_of_days' => $offDay->number_of_days,
                    'status' => $offDay->status,
                ]
            );
        }
    }
}
