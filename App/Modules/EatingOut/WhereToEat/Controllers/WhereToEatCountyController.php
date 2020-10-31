<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatCountyRequest;

class WhereToEatCountyController extends BaseController
{
    public function list(Page $page, WhereToEatCountyRequest $request)
    {
        /** @var WhereToEatCounty $county */
        $county = $request->resolveCounty();

        return $page
            ->breadcrumbs([
                [
                    'link' => '/eating-out',
                    'title' => 'Eating Out',
                ],
                [
                    'link' => '/wheretoeat',
                    'title' => 'Places to Eat',
                ],
            ], $county->county)
            ->setPageTitle('Gluten Free Places to Eat in '.$county->county)
            ->setMetaDescription("Coeliac Sanctuary Places in Cheshire | Eateries who can cater to Coeliac and Gluten Free diets in {$county->county}")
            ->setMetaKeywords([
                "coeliac {$county->county}", "gluten free {$county->county}", "gluten free food {$county->county}",
                "gluten free places to eat in {$county->county}", 'gluten free places to eat', 'gluten free cafes',
                'gluten free restaurants', 'gluten free uk', 'places to eat', 'cafes', 'restaurants', 'eating out',
                'catering to coeliac', 'eating out uk', 'gluten free venues', 'gluten free dining',
                'gluten free directory', 'gf food', $county->county,
            ])
            ->setSocialImage(asset("assets/images/wte-shares/{$county->county}.jpg"))
            ->render('modules.eating-out.wheretoeat.county', [
                'county' => $county->county,
                'slug' => $county->slug,
                'towns' => $county->activeTowns,
                'reviews' => $county->reviews()
                    ->where('reviews.live', true)
                    ->with(['eatery', 'eatery.town', 'eatery.county', 'eatery.ratings'])
                    ->inRandomOrder()
                    ->take(2)->get(),
                'related' => (new ReviewRepository())
                    ->setWiths(['images', 'images.image', 'eatery', 'eatery.town', 'eatery.county'])
                    ->random()
                    ->take(5),
            ]);
    }
}
