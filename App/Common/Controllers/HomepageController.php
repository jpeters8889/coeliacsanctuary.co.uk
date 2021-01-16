<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Services\HomepageService;

class HomepageController extends BaseController
{
    public function handle(Page $page, HomepageService $service): Response
    {
        return $page
            ->loadCriticalCss('home')
            ->render('pages.home', [
                'latestBlogs' => $service->blogs(),
                'latestRecipes' => $service->recipes(),
                'latestReviews' => $service->reviews(),
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
                        'icon' => "['fas', 'utensils']",
                        'label' => 'Reviews',
                        'link' => '/review',
                        'count' => $stats->get('review_count'),
                    ],
                    [
                        'icon' => "['fas', 'store-alt']",
                        'label' => 'Places to Eat',
                        'link' => '/wheretoeat',
                        'count' => $stats->get('wte_count'),
                    ],
                ],
                'heros' => $service->hereoImagesArray(),
            ]);
    }
}
