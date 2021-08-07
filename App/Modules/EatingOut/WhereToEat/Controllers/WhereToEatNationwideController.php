<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;

class WhereToEatNationwideController extends BaseController
{
    public function get(Page $page)
    {
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
            ], 'Nationwide Chains')
            ->setPageTitle('Gluten Free Nationwide Chains')
            ->setMetaDescription('Nationwide chains across the UK that can cater to gluten free diets')
            ->setMetaKeywords([
                "coeliac nationwide chains", "gluten free nationwide chains", "gluten free food at nationwide chains",
                "gluten free places to eat at chains in the uk", 'gluten free places to eat', 'gluten free cafes',
                'gluten free restaurants', 'gluten free uk', 'places to eat', 'cafes', 'restaurants', 'eating out',
                'catering to coeliac', 'eating out uk', 'gluten free venues', 'gluten free dining',
                'gluten free directory', 'gf food', 'nandos', 'tgi fridays', 'hickories', 'leon', 'leon restaurant',
            ])
            ->render('modules.eating-out.wheretoeat.nationwide', [
                'county_id' => WhereToEatCounty::query()->where('slug', 'nationwide')->first()->id,
                'town_id' => WhereToEatTown::query()->where('slug', 'nationwide')->first()->id,
            ]);
    }
}
