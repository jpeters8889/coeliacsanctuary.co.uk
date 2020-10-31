<?php

declare(strict_types=1);

return [
    'image_url' => env('IMAGES_URL'),
    'assets_url' => env('ASSETS_URL'),

    'pagination' => [
        'blogs' => 10,
        'events' => 10,
        'recipes' => 10,
        'reviews' => 10,
        'wheretoeat' => 7,
    ],

    'users' => [
        [
            'name' => 'Jamie',
            'email' => env('JAMIE_EMAIL'),
            'password' => env('JAMIE_PASSWORD'),
        ],
        [
            'name' => 'Ally',
            'email' => env('ALLY_EMAIL'),
            'password' => env('ALLY_PASSWORD'),
        ],
    ],

    'keywords' => [
        'autoimmune disease', 'blogger', 'coeliac disease blog', 'coeliac sanctuary', 'coeliac', 'celiac',
        'coeliac disease', 'blog', 'gluten free blog', 'uk blog', 'food blog', 'gluten free food blog',
        'gluten intolerance', 'lactose intolerance', 'reviews', 'places to eat', 'gluten free', 'gluten',
        'free from', 'free from blog', 'food intolerances',
    ],

    'cache' => [
        'blogs' => [
            'homepage_count' => 'blogs.homepage_count',
            'navigation' => 'blogs.navigation',
        ],
        'recipes' => [
            'homepage_count' => 'recipes.homepage_count',
            'navigation' => 'recipes.navigation',
        ],
        'reviews' => [
            'homepage_count' => 'reviews.homepage_count',
        ],
        'shop' => [
            'navigation' => 'shop.navigation',
        ],
        'wheretoeat' => [
            'js_map_settings' => 'wheretoeat.js_map_settings',
        ],
        'homepage_stats' => 'homepage_stats',
        'featured_images' => [
            'featured_images' => 'featured_images',
        ],
    ],

    'newsletter' => [
      'list' => env('MAILCOACH_NEWSLETTER_LIST', 'Coeliac Sanctuary'),
    ],
];
