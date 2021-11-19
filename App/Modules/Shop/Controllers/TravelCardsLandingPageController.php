<?php

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopCategory;
use Coeliac\Modules\Shop\Models\ShopFeedback;
use Coeliac\Modules\Shop\Response\ShopPage;

class TravelCardsLandingPageController extends BaseController
{
    public function __invoke(ShopPage $page)
    {
        $productIds = [];

        ShopCategory::query()
            ->whereIn('slug', ['standard-coeliac-travel-cards', 'coeliac-and-other-dietary-needs-travel-cards'])
            ->with('products')
            ->get()
            ->each(function(ShopCategory $category) use (&$productIds) {
                $productIds += $category->products()->pluck('id')->toArray();
            });

        return $page
            ->breadcrumbs([[
                'title' => 'Shop',
                'link' => '/shop',
            ]], 'Gluten Free Travel and Translation Cards')
            ->setPageTitle('Gluten Free Travel and Translation Cards')
            ->setMetaDescription('...')
            ->setMetaKeywords(['...'])
            ->render('modules.shop.landing.travel-cards', [
                'feedback' => ShopFeedback::query()
                    ->whereIn('product_id', $productIds)
                    ->with('product')
                    ->inRandomOrder()
                    ->take(3)
                    ->get(),
            ]);
    }
}
