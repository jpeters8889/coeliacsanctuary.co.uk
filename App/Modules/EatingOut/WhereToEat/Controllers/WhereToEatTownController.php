<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatTownRequest;
use Illuminate\Http\Response;

class WhereToEatTownController extends BaseController
{
    public function list(Page $page, WhereToEatTownRequest $request): Response
    {
        /** @var WhereToEatCounty $county */
        /** @var WhereToEatTown $town */
        [$county, $town] = $request->resolveCountyTown();

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
                [
                    'link' => '/wheretoeat/'.$county->slug,
                    'title' => $county->county,
                ],
            ], $town->town)
            ->setPageTitle('Gluten Free Places to Eat in '.$town->town.', '.$county->county)
            ->setMetaDescription("Coeliac Sanctuary gluten free places in {$town->town}, {$county->county} |
            Places can cater to Coeliac and Gluten Free diets in {$town->town}, {$county->county}!")
            ->setMetaKeywords([
                "gluten free {$town->town}", "coeliac {$town->town} eateries", "gluten free {$town->town} eateries",
                'gluten free places to eat in the uk', "gluten free places to eat in {$town->town}",
                'gluten free places to eat', 'gluten free cafes', 'gluten free restaurants', 'gluten free uk',
                'places to eat', 'cafes', 'restaurants', 'eating out', 'catering to coeliac', 'eating out uk',
                'gluten free venues', 'gluten free dining', 'gluten free directory', 'gf food',
            ])
            ->setSocialImage(asset("assets/images/wte-shares/{$county->county}.jpg"))
            ->render('modules.eating-out.wheretoeat.town', [
                'county' => $county,
                'town' => $town,
            ]);
    }
}
