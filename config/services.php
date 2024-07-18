<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'paypal' => [
        'client_id' => env('PAYPAL_CLIENT_ID', ''),
        'client_secret' => env('PAYPAL_CLIENT_SECRET', ''),
        'mode' => env('PAYPAL_MODE', 'sandbox'),
    ],

    'nexmo' => [
        'sms_from' => env('APP_NAME', 'Vonage APIs'),
    ],

    'hotsms' => [
        'username' => 'test',
        'password' => 'tets',
        'sender' => env('APP_NAME'),
    ],

    'onesignal' => [
        'app_id' => env('ONE_SIGNAL_APP_ID'),
        'auth_key' => env('ONE_SIGNAL_AUTH_KEY'),
        'authorize' => env('ONE_SIGNAL_AUTHORIZE'),
    ],

    'releans' => [
        'sender_id' => env('SENDER_ID'),
        'authorize' => env('RELEANS_AUTHORIZE'),
    ],
];
