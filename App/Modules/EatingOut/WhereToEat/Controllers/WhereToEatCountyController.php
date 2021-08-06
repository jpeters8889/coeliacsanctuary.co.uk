<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\WhereToEatCountyRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Support\CountyProcessor;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

class WhereToEatCountyController extends BaseController
{
    public function list(Page $page, CountyProcessor $countyProcessor)
    {
        $county = $countyProcessor->county();

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
            ->setPageTitle('Gluten Free Places to Eat in ' . $county->county)
            ->setMetaDescription("Eateries who can cater to Coeliac and Gluten Free diets in {$county->county} | Gluten free places to eat in {$county->county}")
            ->setMetaKeywords($countyProcessor->keywords())
            ->setSocialImage(asset("assets/images/wte-shares/{$county->county}.jpg"))
            ->render('modules.eating-out.wheretoeat.county', [
                'id' => $county->id,
                'county' => $county->county,
                'slug' => $county->slug,
                'towns' => $county->activeTowns,
                'topPlaces' => $countyProcessor->topRatedPlaces(),
                'reviews' => $countyProcessor->reviews(),
            ]);
    }
}
