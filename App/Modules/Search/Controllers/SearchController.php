<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Controllers;

use Illuminate\Http\Request;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Search\Models\SearchHistory;
use Coeliac\Modules\Search\Requests\SearchRequest;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\Search\Service\Search as SearchService;

class SearchController extends BaseController
{
    private array $models;

    public function __construct()
    {
        $this->models = [
            'blogs' => Blog::class,
            'reviews' => Review::class,
            'recipes' => Recipe::class,
            'eateries' => WhereToEat::class,
            'products' => ShopProduct::class,
        ];
    }

    public function get(Page $page, Request $request)
    {
        if ($request->get('q')) {
            SearchHistory::query()->firstOrCreate(['term' => $request->get('q')])->increment('number_of_searches');
        }

        return $page->doNotIndex()
            ->breadcrumbs([], 'Search Results')
            ->setPageTitle("{$request->get('q')} | Search Results")
            ->render('modules.search.index', [
                'term' => $request->get('q'),
            ]);
    }

    public function create(SearchRequest $request, SearchService $searchService)
    {
        return $searchService->searchFor($request->input('term'))
            ->shouldSearchBlogs($request->input('areas.blogs'))
            ->shouldSearchRecipes($request->input('areas.recipes'))
            ->shouldSearchReviews($request->input('areas.reviews'))
            ->shouldSearchEateries($request->input('areas.eateries'))
            ->shouldSearchProducts($request->input('areas.products'))
            ->handle()->paginate(10);
    }
}
