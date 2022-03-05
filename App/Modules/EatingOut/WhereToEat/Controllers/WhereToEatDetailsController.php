<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatDetailsRequest;
use Illuminate\Http\Response;

class WhereToEatDetailsController extends BaseController
{
    public function __invoke(WhereToEatDetailsRequest $request, Page $page): Response
    {
        $eatery = $request->resolveEatery();

        return $page
            ->noBreadcrumbs()
            ->setPageTitle($eatery->full_name)
            ->setMetaDescription("Eat gluten free at {$eatery->full_name}")
            ->setMetaKeywords([
                "gluten free {$eatery->town->town}", "coeliac {$eatery->town->town} eateries",
                "gluten free {$eatery->town->town} eateries", 'gluten free places to eat in the uk',
                "gluten free places to eat in {$eatery->town->town}", 'gluten free places to eat',
                'gluten free cafes', 'gluten free restaurants', 'gluten free uk', 'places to eat',
                'cafes', 'restaurants', 'eating out', 'catering to coeliac', 'eating out uk',
                'gluten free venues', 'gluten free dining', 'gluten free directory', 'gf food',
            ])
            ->setSocialImage(asset("assets/images/wte-shares/{$eatery->county->county}.jpg"))
            ->render('modules.eating-out.wheretoeat.details', [
                'eatery' => $eatery->only([
                    'address', 'average_price_range', 'average_rating', 'county', 'cuisine', 'features', 'formatted_address',
                    'gf_menu_link', 'has_been_rated', 'icon', 'id', 'info', 'lat', 'lng', 'openingTimes', 'name', 'phone',
                    'restaurants', 'town', 'type', 'userReviews', 'venueType', 'website',
                ]),
            ]);
    }
}
