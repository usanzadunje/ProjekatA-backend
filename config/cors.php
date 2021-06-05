<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' =>
        [
            'api/*',
            'sanctum/csrf-cookie',
            'login',
            'login',
            'logout',
            'register',
            'user/password',
            'forgot-password',
            'reset-password',
            'email/verification-notification',
            'user/profile-information',
        ],

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://192.168.1.203:8100'],

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true,

];
