<?php

namespace App\Actions\Notifications;

use LaravelFCM\Facades\FCM;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class SendNotificationViaFCM
{
    public function handle(array $tokens, string $title, string $body = null, string $sound = 'default', $notificationData = []): void
    {
        $optionsBuilder = new OptionsBuilder();
        $optionsBuilder->setContentAvailable(true);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder
            ->setBody($body)
            ->setSound($sound)
            ->setIcon('ic_table_chart')
            ->setColor('#FF0000');

        $notification = $notificationBuilder->build();
        $options = $optionsBuilder->build();

        $data = null;
        if($notificationData)
        {
            $dataBuilder = new PayloadDataBuilder();
            $dataBuilder->addData($notificationData);

            $data = $dataBuilder->build();
        }

        FCM::sendTo($tokens, $options, $notification, $data);
    }
}