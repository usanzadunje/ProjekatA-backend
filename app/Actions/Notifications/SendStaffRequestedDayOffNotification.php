<?php


namespace App\Actions\Notifications;

use App\Models\OffDay;
use App\Models\User;

class SendStaffRequestedDayOffNotification
{
    public function __construct(protected SendDataNotificationViaFCM $sendDataNotificationViaFCM)
    {
    }

    public function handle(OffDay $offDay): void
    {
        $token = User::whereId(function($query) use ($offDay) {
            $query
                ->select('user_id')
                ->from('places')
                ->where('id', $offDay->user->place);
        }
        )->first()->fcm_token;

        if(!empty($token))
        {
            $endDate = $offDay->start_date->addDays($offDay->number_of_days - 1);
            $endDate = "{$endDate->day}-{$endDate->month}-{$endDate->year}";
            $startDate = "{$offDay->start_date->day}-{$offDay->start_date->month}-{$offDay->start_date->year}";

            $this->sendDataNotificationViaFCM->handle(
                $token,
                [
                    'type' => 'staffRequestedDayOff',
                    'id' => abs(crc32(uniqid())),
                    'request_id' => $offDay->id,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'number_of_days' => $offDay->number_of_days,
                    'staff' => $offDay->user()->select('fname', 'lname', 'username')->first(),
                    'message' => $offDay->message,
                ]
            );
        }
    }
}
