<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\SearchRequest;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSearchTerm;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\SearchCreateRequest;
use Illuminate\Http\Response;

class WhereToEatSearchController extends BaseController
{
    public function create(SearchCreateRequest $request): array
    {
        /** @var WhereToEatSearchTerm $search */
        $search = WhereToEatSearchTerm::query()->firstOrCreate([
            'term' => $request->input('text'),
            'range' => $request->input('range'),
        ]);

        $search->logSearch();

        return [
            'search' => $search->key,
        ];
    }

    public function get(Page $page, SearchRequest $request): Response
    {
        $searchTerm = $request->resolveSearchTerm();

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
            ], 'Search Results')
            ->setPageTitle('Gluten Free Search Results for '.$searchTerm->term)
            ->setMetaDescription('Gluten Free Search Results for '.$searchTerm->term)
            ->render('modules.eating-out.wheretoeat.search', [
                'search' => $searchTerm
            ]);
    }
}
