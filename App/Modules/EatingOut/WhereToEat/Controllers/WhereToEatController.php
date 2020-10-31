<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Illuminate\Http\Request;
use Coeliac\Common\Response\Page;
use Illuminate\Support\Collection;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Coeliac\Modules\EatingOut\WhereToEat\IndexCountyList;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;

class WhereToEatController extends BaseController
{
    private Page $page;

    private Repository $repository;

    public function __construct(Page $page, Repository $repository)
    {
        $this->page = $page;
        $this->repository = $repository;
    }

    public function index(IndexCountyList $countyList)
    {
        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/eating-out',
                    'title' => 'Eating Out',
                ],
            ], 'Places to Eat')
            ->setPageTitle('Gluten Free Places to Eat Guide')
            ->setMetaDescription('Coeliac Sanctuary where to eat guide | Places in the UK who can cater to Coeliac and gluten free diets')
            ->setMetaKeywords([
                'gluten free places to eat', 'gluten free cafes', 'gluten free restaurants', 'gluten free uk', 'places to eat',
                'cafes', 'restaurants', 'eating out', 'catering to coeliac', 'eating out uk', 'gluten free venues',
                'gluten free dining', 'gluten free directory', 'gf food', 'gluten free eating out uk', 'uk places to eat',
                'gluten free attractions', 'gluten free hotels',
            ])
            ->setSocialImage(asset('assets/images/shares/wheretoeat.jpg'))
            ->render('modules.eating-out.wheretoeat.index', [
                'list' => $countyList->getStats(),
                'nationwide_id' => WhereToEatCounty::query()->where('county', 'Nationwide')->first()->value('id'),
                'related' => (new ReviewRepository())->random()->take(10),
            ]);
    }

    public function list(Request $request)
    {
        $this->validate($request, [
            'limit' => 'integer|max:50',
        ]);

        return [
            'data' => (new Collection($this->repository
                ->setWiths([
                    'country', 'county', 'town', 'type', 'venueType', 'cuisine', 'features', 'restaurants',
                    'reviews' => function (Relation $builder) {
                        return $builder->select(['id', 'wheretoeat_id', 'title', 'slug', 'created_at'])->where('live', 1)->latest();
                    },
                    'ratings' => function (Relation $builder) {
                        return $builder->select(['id', 'wheretoeat_id', 'rating', 'name', 'body', 'created_at'])->where('approved', 1)->latest();
                    },
                ])
                ->filter()
                ->search()
                ->paginated($request->get('limit', 10))))
                ->merge(['appends' => $this->repository->getAppends()]),
        ];
    }
}
