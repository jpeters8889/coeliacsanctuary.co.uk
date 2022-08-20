<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Search\Models\SearchHistory;
use Coeliac\Modules\Search\Requests\SearchRequest;
use Coeliac\Modules\Search\Service\Search as SearchService;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Pagination\LengthAwarePaginator;

class SearchController extends BaseController
{
    protected array $models;

    public function __construct()
    {
        $this->models = [
            'blogs' => Blog::class,
            'recipes' => Recipe::class,
            'eateries' => WhereToEat::class,
            'products' => ShopProduct::class,
        ];
    }

    public function get(Page $page, Request $request): Response
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

    public function create(SearchRequest $request, SearchService $searchService): LengthAwarePaginator
    {
        return $searchService->searchFor($request->input('term'))
            ->shouldSearchBlogs($request->input('areas.blogs'))
            ->shouldSearchRecipes($request->input('areas.recipes'))
            ->shouldSearchEateries($request->input('areas.eateries'))
            ->shouldSearchProducts($request->input('areas.products'))
            ->handle()
            ->paginate(10);
    }
}
