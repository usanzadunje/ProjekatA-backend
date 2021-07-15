<?php

namespace App\Services;


use App\Models\User;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\PayloadDataBuilder;

class SendNotificationViaFCM
{
    public function sendNotifications($tokens)
    {
        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => 'data']);

        $data = $dataBuilder->build();

        FCM::sendTo($tokens, null, null, $data);
    }
}