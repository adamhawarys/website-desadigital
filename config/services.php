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

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_REDIRECT'),
    ],

    'aws' => [
    'key'           => env('AWS_ACCESS_KEY_ID'),
    'secret'        => env('AWS_SECRET_ACCESS_KEY'),
    'region'        => env('AWS_DEFAULT_REGION', 'ap-southeast-1'),
    'bucket'        => env('AWS_BUCKET'),
    'sqs_url'       => env('AWS_SQS_URL'),
    'sns_topic_arn' => env('AWS_SNS_TOPIC_ARN'),
    'sns_topic_arn_admin' => env('AWS_SNS_TOPIC_ARN_ADMIN'),
    ],

];
