<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Services\NavigationService;

class NavigationController extends BaseController
{
    public function get(NavigationService $navigationService): array
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
                'layout' => '4',
                'items' => [
                    [
                        'title' => 'Eating Out Guide',
                        'slug' => '/wheretoeat',
                        'link' => '/wheretoeat',
                        'meta_description' => 'Coeliac Sanctuary\'s Eating Out guide, listing places all over the UK who can cater to Coeliac and gluten free diets, including attractions and hotels.',
                        'main_image' => asset('assets/images/shares/wheretoeat.jpg'),
                    ],
                    [
                        'title' => 'Eating Out Map',
                        'slug' => '/wheretoeat/browse',
                        'link' => '/wheretoeat/browse',
                        'meta_description' => 'Not sure where to go? Check out our interactive map showing all of the gluten places to eat across the UK and Ireland.',
                        'main_image' => asset('assets/images/shares/wheretoeat-map.jpg'),
                    ],
                    [
                        'title' => 'Nationwide Chains',
                        'slug' => '/wheretoeat/nationwide',
                        'link' => '/wheretoeat/nationwide',
                        'meta_description' => 'Nationwide chains across the UK that can cater to gluten free diets',
                        'main_image' => asset('assets/images/shares/wheretoeat.jpg'),
                    ],
                    [
                        'title' => 'Coeliac Sanctuary - On the Go App',
                        'slug' => '/wheretoeat/coeliac-sanctuary-on-the-go',
                        'link' => '/wheretoeat/coeliac-sanctuary-on-the-go',
                        'meta_description' => 'Get all of our gluten free places to eat in your pocket.',
                        'main_image' => asset('assets/images/shares/wheretoeat-app.jpg'),
                    ],
                ],
            ],
            'collections' => [
                'layout' => '3x5',
                'items' => $navigationService->collections(),
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
