<?php

namespace App\Actions\Notifications;

use LaravelFCM\Facades\FCM;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;

class SendNotificationViaFCM
{
    public function handle(array $tokens, string $title, string $body = null, string $sound = 'default'): void
    {
        $optionsBuilder = new OptionsBuilder();
        $optionsBuilder->setContentAvailable(true);

        $notificationBuilder = new PayloadNotificationBuilder($title);
        $notificationBuilder
            ->setBody($body)
            ->setSound($sound);
        //->setIcon()


        $notification = $notificationBuilder->build();
        $options = $optionsBuilder->build();

        FCM::sendTo($tokens, $options, $notification, null);
    }
}