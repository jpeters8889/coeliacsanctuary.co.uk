<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Http\Request;
use Coeliac\Common\Response\Page;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Illuminate\Database\Eloquent\Relations\Relation;
use Coeliac\Modules\EatingOut\WhereToEat\Support\IndexCountyList;

class WhereToEatController extends BaseController
{
    public function __construct(private Page $page, private Repository $repository)
    {
    }

    public function index(IndexCountyList $countyList): Response
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
                'gluten free places to eat', 'gluten free cafes', 'gluten free restaurants', 'gluten free uk',
                'places to eat', 'cafes', 'restaurants', 'eating out', 'catering to coeliac', 'eating out uk',
                'gluten free venues', 'gluten free dining', 'gluten free directory', 'gf food',
                'gluten free eating out uk', 'uk places to eat', 'gluten free attractions', 'gluten free hotels',
            ])
            ->setSocialImage(asset('assets/images/shares/wheretoeat.jpg'))
            ->render('modules.eating-out.wheretoeat.index', [
                'list' => $countyList->getStats(),
                'topPlaces' => $countyList->topPlaces(),
            ]);
    }

    public function list(Request $request): array
    {
        $this->validate($request, [
            'limit' => 'integer|max:50',
        ]);

        $eateries = new Collection($this->repository
            ->setWiths([
                'country', 'county', 'town', 'type', 'venueType', 'cuisine', 'features', 'restaurants',
                'reviews' => function (Relation $builder) {
                    /** @phpstan-ignore-next-line */
                    return $builder
                        ->with(['eatery', 'eatery.town', 'eatery.county', 'eatery.country', 'images'])
                        ->select(['id', 'wheretoeat_id', 'title', 'slug', 'created_at'])
                        ->where('live', 1)
                        ->latest();
                },
                'userReviews' => function (Relation $builder) {
                    /** @phpstan-ignore-next-line */
                    return $builder
                        ->select(['id', 'wheretoeat_id', 'rating', 'name', 'body', 'created_at'])
                        ->where('approved', 1)
                        ->latest();
                },
            ])
            ->filter()
            ->search()
            ->setColumns(['wheretoeat.*'])
            ->paginated((int)$request->get('limit', 10))
            ->through(function (WhereToEat $eatery) {
                $eatery->ratings = $eatery->userReviews;

                return $eatery;
            }));

        return [
            'data' => $eateries
                ->merge(['appends' => $this->repository->getAppends()]),
        ];
    }

    public function get(mixed $id): WhereToEat|BaseModel|null
    {
        $eatery = $this->repository
            ->setWiths([
                'country', 'county', 'town', 'type', 'venueType', 'cuisine', 'features', 'restaurants',
                'reviews', 'openingTimes',
                'userImages' => fn(Relation $relation) => $relation->whereRelation('review', 'approved', true),
                'userReviews' => fn(Relation $builder) => $builder
                    ->with(['images'])
                    ->select([
                        'id', 'wheretoeat_id', 'rating', 'name', 'body', 'how_expensive', 'created_at',
                        'admin_review', 'food_rating', 'service_rating', 'branch_name',
                    ])
                    ->where('approved', 1)
                    ->latest(),
            ])
            ->get($id);

        $eatery->ratings = $eatery->userReviews;

        return $eatery;
    }
}
