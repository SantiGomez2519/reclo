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

    'pexels' => [
        'url' => env('API_URL_PEXELS', 'https://api.pexels.com/v1'),
        'key' => env('API_KEY_PEXELS'),
        'cache_ttl' => env('PEXELS_CACHE_TTL', 3600),
        'category_map' => [
            'Women' => 'women fashion clothing',
            'Men' => 'men fashion clothing',
            'Vintage' => 'vintage clothing',
            'Accessories' => 'fashion accessories',
            'Shoes' => 'shoes footwear',
            'Bags' => 'bags handbags',
            'Jewelry' => 'jewelry',
        ],
        'max_images' => 5,
        'orientation' => 'portrait',
    ],

];
