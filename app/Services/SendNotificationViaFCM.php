<?php

namespace App\Services;


use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class SendNotificationViaFCM
{
    public function sendNotifications($tokens)
    {
        $notificationBuilder = new PayloadNotificationBuilder('my title');
        $notificationBuilder->setBody('Hello world!!!')
            ->setSound('default');


        $notification = $notificationBuilder->build();

        FCM::sendTo($tokens, null, $notification, null);
    }
}