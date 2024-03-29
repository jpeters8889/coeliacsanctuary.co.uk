<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3", "rackspace"
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        'images' => [
            'driver' => env('IMAGES_STORAGE_DRIVER', 's3'),
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'eu-west-2'),
            'bucket' => env('AWS_BUCKET', 'coeliac-images'),
            'options' => [
                'CacheControl' => 'max-age=315360000, no-transform, public',
            ],
        ],

        'review-images' => [
            'driver' => env('IMAGES_STORAGE_DRIVER', 's3'),
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'eu-west-2'),
            'bucket' => env('AWS_REVIEW_IMAGES_BUCKET', 'coeliac-review-images'),
            'options' => [
                'CacheControl' => 'max-age=315360000, no-transform, public',
            ],
            'throw' => true,
        ],

        'uploads' => [
            'driver' => env('IMAGES_STORAGE_DRIVER', 's3'),
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'eu-west-2'),
            'bucket' => env('AWS_FILE_UPLOADS_BUCKET', 'coeliac-file-uploads'),
        ],

        'search' => [
            'driver' => 'local',
            'root' => storage_path('app/search'),
            'visibility' => 'private',
        ],

        'backups' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION', 'eu-west-2'),
            'bucket' => 'coeliac-backups',
        ],
    ],
];
