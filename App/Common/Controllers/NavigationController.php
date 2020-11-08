<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Services\NavigationService;

class NavigationController extends BaseController
{
    public function get(NavigationService $navigationService)
    {
        return [
            'shop' => [
                'layout' => '3x5',
                'items' => $navigationService->products(),
            ],
            'blogs' => [
                'layout' => '3x5',
                'items' => $navigationService->blogs(),
            ],
            'recipes' => [
                'layout' => '3x5',
                'items' => $navigationService->recipes(),
            ],
            'eatingOut' => [
                'layout' => '3',
                'items' => [
                    [
                        'title' => 'UK and Ireland Eateries',
                        'slug' => '../wheretoeat',
                        'link' => '../wheretoeat',
                        'meta_description' => 'Coeliac Sanctuary\'s Where to Eat guide, listing places in the UK who can cater to Coeliac and gluten free diets, including attractions and hotels.',
                        'main_image' => asset('assets/images/shares/wheretoeat.jpg'),
                    ],
                    [
                        'title' => 'Reviews',
                        'slug' => '../review',
                        'link' => '../review',
                        'meta_description' => 'Read honest reviews of places to eat from the Coeliac Sanctuary team',
                        'main_image' => asset('assets/images/shares/review-list.jpg'),
                    ],
                    [
                        'title' => 'Coeliac Sanctuary - On the Go App',
                        'slug' => '../wheretoeat/coeliac-sanctuary-on-the-go',
                        'link' => '../wheretoeat/coeliac-sanctuary-on-the-go',
                        'meta_description' => 'Get all of our gluten free places to eat in your pocket.',
                        'main_image' => asset('assets/images/shares/wheretoeat-app.jpg'),
                    ],
                ],
            ],
            'info' => [
                'layout' => 'list',
                'items' => [
                    [
                        'label' => 'About Us',
                        'link' => '/about',
                    ],
                    [
                        'label' => 'FAQ',
                        'link' => '/faq',
                    ],
                    [
                        'label' => 'Contact Us',
                        'component' => 'contact-trigger',
                    ],
                    [
                        'label' => 'Coeliac Disease Information',
                        'link' => '/info/coeliac',
                    ],
                    [
                        'label' => 'Beginners Shopping List',
                        'link' => '/info/shopping-list',
                    ],
                    [
                        'label' => 'Storecupboard Checklist',
                        'link' => '/info/storecupboard-check',
                    ],
                    [
                        'label' => 'Gluten Challenge',
                        'link' => '/info/gluten-challenge',
                    ],
                    [
                        'label' => 'Work With Us',
                        'link' => '/work-with-us',
                    ],
                ],
            ],
        ];
    }
}
