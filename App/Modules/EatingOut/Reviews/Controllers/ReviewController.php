<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Controllers;

use Illuminate\Http\Request;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\Reviews\Repository;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Collection\Models\CollectionItem;
use Coeliac\Modules\EatingOut\Reviews\Requests\ReviewShowRequest;
use Illuminate\Http\Response;

class ReviewController extends BaseController
{
    public function __construct(private Page $page, private Repository $repository)
    {
    }

    public function index(): Response
    {
        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/eating-out',
                    'title' => 'Eating Out',
                ],
            ], 'Reviews')
            ->setPageTitle('Gluten Free Places To Eat Reviews')
            ->setMetaDescription('Coeliac Sanctuary gluten free review list | All the gluten free places we have reviewed in the UK can be found here')
            ->setMetaKeywords([
                'coeliac sanctuary reviews', 'review index', 'index', 'review list', 'autoimmune disease', 'places to eat reviews',
                'gluten free restaurant reviews', 'coeliac places to eat', 'reviews of gluten free places', 'uk places to eat',
            ])
            ->setSocialImage(asset('assets/images/shares/review-list.jpg'))
            ->render('modules.reviews.index');
    }

    public function list(Request $request): array
    {
        $this->validate($request, [
            'limit' => 'integer,max:50',
        ]);

        return [
            'data' => $this->repository
                ->setWithCounts(['comments'])
                ->setWiths(['eatery', 'eatery.town', 'eatery.county', 'eatery.country', 'eatery.type', 'images', 'images.image'])
                ->setColumns(['id', 'wheretoeat_id', 'title', 'slug', 'overall_rating', 'meta_tags', 'meta_description', 'created_at'])
                ->filter()
                ->search()
                ->paginated($request->get('limit', 12)),
        ];
    }

    public function show(ReviewShowRequest $request): Response
    {
        /* @var Review $review */
        abort_if(!$review = $request->resolveItem(), 404, 'Sorry, this review can\'t be found');

        $featured = null;

        if ($review->associatedCollections()->count() > 0) {
            $featured = $review->associatedCollections()
                ->inRandomOrder()
                ->take(3)
                ->get()
                ->transform(fn (CollectionItem $item) => $item->collection);
        }

        return $this->page
            ->breadcrumbs([
                [
                    'link' => '/eating-out',
                    'title' => 'Eating Out',
                ],
                [
                    'link' => '/review',
                    'title' => 'Reviews',
                ],
            ], $review->title)
            ->scrapable('review', $review->id)
            ->setPageTitle($review->title.' | Reviews')
            ->setMetaDescription($review->meta_description)
            ->setMetaKeywords(explode(',', (string) $review->meta_keywords))
            ->setSocialImage($review->social_image)
            ->render('modules.reviews.show', compact('review', 'featured'));
    }
}
