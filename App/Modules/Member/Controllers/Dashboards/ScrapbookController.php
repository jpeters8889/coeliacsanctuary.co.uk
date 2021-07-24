<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers\Dashboards;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Requests\ScrapbookCreateRequest;
use Coeliac\Modules\Member\Requests\ScrapbookUpdateRequest;

class ScrapbookController extends BaseController
{
    public function show(Page $page, Request $request): Response
    {
        return $page->setPageTitle('Scrapbooks')
            ->breadcrumbs([
                ['title' => 'Your Dashboard', 'link' => '/member/dashboard'],
            ], 'Scrapbooks')
            ->render('modules.member.dashboards.scrapbook', [
                'user' => $request->user(),
            ]);
    }

    public function list(Request $request)
    {
        return $request->user()->scrapbooks()->withCount('items')->orderBy('name')->get();
    }

    public function create(ScrapbookCreateRequest $request)
    {
        $request->user()->scrapbooks()->create($request->validated());
    }

    public function update(ScrapbookUpdateRequest $request, Scrapbook $scrapbook)
    {
        $scrapbook->update($request->validated());
    }

    public function delete(Request $request, Scrapbook $scrapbook, Gate $gate)
    {
        $gate->authorize('manage-scrapbook', $scrapbook);

        if ($request->user()->scrapbooks()->count() === 1) {
            return new Response(['error' => 'You must have at least one scrapbook'], 422);
        }

        $scrapbook->delete();
    }
}
