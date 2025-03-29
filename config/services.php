<?php
return [
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
    'google' => [
        'client_id' => env('client_id_google'),
        'client_secret' => env('client_secret_google'),
        'redirect' => env('redirect_google'),
    ],
    'facebook' => [
        'client_id' => env('client_id_facebook'),
        'client_secret' => env('client_secret_facebook'),
        'redirect' => env('redirect_facebook'),
    ],
];
