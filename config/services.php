<?php

declare(strict_types=1);

return [
    'google' => [
        'maps' => [
            'key' => env('GOOGLE_MAP_KEY'),
            'static' => env('GOOGLE_MAP_STATIC'),
            'dynamic' => env('GOOGLE_MAP_DYNAMIC'),
            'directions' => env('GOOGLE_MAP_DIRECTIONS'),
            'search' => env('GOOGLE_MAP_SEARCH'),
            'big' => env('GOOGLE_MAP_BIG'),
            'admin' => env('GOOGLE_MAP_ADMIN'),
        ],
    ],
    'mailchimp' => [
        'key' => env('MAILCHIMP_KEY'),
        'list' => env('MAILCHIMP_LIST'),
    ],
    'mjml' => [
        'compiler' => env('MJML_URL'),
    ],
    'postcode' => [
        'key' => env('POSTCODE_KEY'),
        'secret' => env('POSTCODE_SECRET'),
    ],
    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'eu-west-2',
    ],
    'shop' => [
        'payments' => [
            'stripe' => [
                'public' => env('STRIPE_PUBLIC_KEY'),
                'secret' => env('STRIPE_SECRET_KEY'),
            ],
            'paypal' => [
                'client' => env('PAYPAL_CLIENT_KEY'),
                'secret' => env('PAYPAL_SECRET_KEY'),
            ],
        ],
    ],
];
