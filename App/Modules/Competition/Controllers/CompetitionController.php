<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Controllers;

use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Competition\Models\Competition;
use Coeliac\Modules\Competition\Requests\CompetitionInitialEntryRequest;
use Coeliac\Modules\Competition\Requests\CompetitionAdditionalEntryRequest;

class CompetitionController extends BaseController
{
    public function get(Competition $competition, Page $page)
    {
        abort_if(!$competition->isActive(), 404);

        return $page->breadcrumbs([], $competition->name)
            ->setPageTitle($competition->name)
            ->setMetaDescription($competition->meta_description)
            ->setMetaKeywords(explode(',', $competition->meta_keywords))
            ->setSocialImage($competition->first_image)
            ->doNotIndex()
            ->render('modules.competition.competition', compact('competition'));
    }

    public function create(CompetitionInitialEntryRequest $request, Competition $competition)
    {
        if ($request->userHasAlreadyEntered()) {
            return new Response(['error' => 'duplicate entry'], 422);
        }

        return $competition->entries()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'entry_type' => 'primary',
        ])->only('id');
    }

    public function update(CompetitionAdditionalEntryRequest $request, Competition $competition)
    {
        $primaryEntry = $request->getPrimaryEntry();

        if ($request->userHasAlreadyEnteredAdditionalType($primaryEntry)) {
            return new Response(['error' => 'duplicate entry'], 422);
        }

        $competition->entries()->create([
            'name' => $primaryEntry->name,
            'email' => $primaryEntry->email,
            'entry_type' => $request->input('type'),
        ]);
    }
}
