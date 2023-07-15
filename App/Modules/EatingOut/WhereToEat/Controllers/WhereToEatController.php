<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Support\EateryProcessors\EateryListProcessor;
use Coeliac\Modules\EatingOut\WhereToEat\Support\IndexCountyList;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class WhereToEatController extends BaseController
{
    public function __construct(protected Page $page, protected Repository $repository)
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

    public function list(Request $request, EateryListProcessor $listProcessor): array
    {
        $this->validate($request, [
            'limit' => 'integer|max:50',
        ]);

        return [
            'data' => collect($listProcessor->getEateries())->merge(['appends' => $listProcessor->getAppends()]),
        ];
    }

    public function get(Request $request, mixed $id): WhereToEat|BaseModel|null
    {
        $eatery = $this->repository
            ->setWiths([
                'country', 'county', 'town', 'type', 'venueType', 'cuisine', 'features', 'restaurants',
                'reviews', 'openingTimes',
                'userImages' => fn (HasMany $relation) => $relation->whereRelation('review', 'approved', true),
                'userReviews' => fn (HasMany $builder) => $builder
                    ->with(['images'])
                    ->select([
                        'id', 'wheretoeat_id', 'rating', 'name', 'body', 'how_expensive', 'created_at',
                        'admin_review', 'food_rating', 'service_rating', 'branch_name',
                    ])
                    ->where('approved', 1)
                    ->latest(),
            ])
            ->get($id);

        /** @phpstan-ignore-next-line */
        $eatery->ratings = $eatery->userReviews;

        if ($request->get('branch')) {
            $eatery->branch = $eatery->branches()
                ->with(['town', 'county', 'country'])
                ->find($request->get('branch'));
            $eatery->is_nationwide = true;
        }

        return $eatery;
    }
}
