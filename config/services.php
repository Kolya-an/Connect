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

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id' => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect' => env('GOOGLE_REDIRECT_URI'),
        'maps_api_key' => env('GOOGLE_MAPS_API_KEY'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT_URI'),
    ],
    'openstreetmap' => [
        'base_url' => 'https://nominatim.openstreetmap.org/',
        'timeout' => 10,
    ],

    'diia' => [
        'env'                 => env('DIIA_ENV', 'sandbox'),
        'base_url'            => env('DIIA_BASE_URL', 'https://api2s.diia.gov.ua'),
        'acquirer_token'      => env('DIIA_ACQUIRER_TOKEN'),
        'auth_acquirer_token' => env('DIIA_AUTH_ACQUIRER_TOKEN'),
        'redirect_uri'        => env('DIIA_REDIRECT_URI'),
        //'webhook_url' => env('DIIA_WEBHOOK_URL', 'https://connect-cosmetology.com/api/diia/webhook'),
        'branch_id' => env('DIIA_BRANCH_ID'),
        'offer_id' => env('DIIA_OFFER_ID'),
        'webhook_url' => env('DIIA_WEBHOOK_URL', rtrim(env('APP_URL'), '/') . '/api/diia/webhook'),
    ],

];
