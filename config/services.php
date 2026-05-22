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

    'wa_qontak' => [
        'token'                  => env('WA_QONTAK_TOKEN'),
        'refresh_token'          => env('WA_QONTAK_REFRESH_TOKEN'),
        'channel_integration_id' => env('WA_QONTAK_CHANNEL_INTEGRATION_ID'),
        'sender_number'          => env('WA_QONTAK_SENDER_NUMBER'),
        'template_id'            => env('WA_QONTAK_TEMPLATE_ID'),
        'numbers'                => env('WA_QONTAK_NUMBERS'),
        'verify_ssl'             => env('WA_QONTAK_VERIFY_SSL', true),
    ],

];
