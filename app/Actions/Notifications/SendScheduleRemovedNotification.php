<?php


namespace App\Actions\Notifications;

use App\Models\Schedule;

class SendScheduleRemovedNotification
{
    public function __construct(protected SendDataNotificationViaFCM $sendDataNotificationViaFCM)
    {
    }

    public function handle(Schedule $schedule): void
    {
        $token = $schedule->user->fcm_token;

        if(!empty($token)) {
            $this->sendDataNotificationViaFCM->handle(
                $token,
                [
                    'type' => 'scheduleRemoved',
                    'id' => abs(crc32(uniqid())),
                    'schedule_id' => $schedule->id,
                    'day' => $schedule->start_date->day,
                    'month' => $schedule->start_date->month,
                    'year' => $schedule->start_date->year,
                ]
            );
        }
    }
}
