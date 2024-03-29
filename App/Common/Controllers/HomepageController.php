<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Common\Services\HomepageService;
use Illuminate\Http\Response;

class HomepageController extends BaseController
{
    public function handle(Page $page, HomepageService $service): Response
    {
        return $page
            ->loadCriticalCss('home')
            ->render('pages.home', [
                'latestBlogs' => $service->blogs(),
                'latestRecipes' => $service->recipes(),
                'latestRatings' => $service->ratings(),
                'latestPlaces' => $service->latestPlaces(),
                'stats' => [
                    [
                        'icon' => "['fas', 'shopping-basket']",
                        'label' => 'Products for sale',
                        'link' => '/shop',
                        'count' => ($stats = $service->statistics())->get('product_count'),
                    ],
                    [
                        'icon' => "['far', 'newspaper']",
                        'label' => 'Blogs',
                        'link' => '/blog',
                        'count' => $stats->get('blog_count'),
                    ],
                    [
                        'icon' => "['fas', 'pizza-slice']",
                        'label' => 'Recipes',
                        'link' => '/recipe',
                        'count' => $stats->get('recipe_count'),
                    ],
                    [
                        'icon' => "['fas', 'store-alt']",
                        'label' => 'Places to Eat',
                        'link' => '/wheretoeat',
                        'count' => $stats->get('wte_count'),
                    ],
                    [
                        'icon' => "['fas', 'utensils']",
                        'label' => 'Ratings and Reviews',
                        'link' => '/wheretoeat',
                        'count' => $stats->get('wte_reviews_count'),
                    ],
                ],
            ]);
    }
}
