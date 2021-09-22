<?php

namespace App\Actions\Notifications;

use LaravelFCM\Facades\FCM;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;

class SendDataNotificationViaFCM
{
    public function handle(array $tokens, $notificationData = []): void
    {
        $optionsBuilder = new OptionsBuilder();
        $optionsBuilder->setContentAvailable(true);

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData($notificationData);

        $data = $dataBuilder->build();
        $options = $optionsBuilder->build();

        FCM::sendTo($tokens, $options, null, $data);
    }
}