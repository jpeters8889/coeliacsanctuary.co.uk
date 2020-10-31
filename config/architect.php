<?php

declare(strict_types=1);

use JPeters\Architect\Http\Middleware\Authenticate;
use JPeters\Architect\Http\Middleware\ArchitectIsRunning;
use JPeters\Architect\Http\Middleware\CanAccessArchitect;

return [
    'name' => 'Coeliac Sanctuary',

    // The route to access the admin panel
    'route' => 'cs-adm',

    'upload_directory' => 'cs-adm-uploads',

    'middleware' => [
        'web',
        Authenticate::class,
        CanAccessArchitect::class,
        ArchitectIsRunning::class,
    ],

    'gateway' => Coeliac\Common\ArchitectGateway::class,
];
