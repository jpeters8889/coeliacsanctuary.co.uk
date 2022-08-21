<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Competition\Models\Competition;
use Coeliac\Modules\Competition\Requests\CompetitionAdditionalEntryRequest;
use Coeliac\Modules\Competition\Requests\CompetitionInitialEntryRequest;
use Illuminate\Http\Response;

class CompetitionController extends BaseController
{
    public function get(Competition $competition, Page $page): Response
    {
        abort_if(! $competition->isActive(), 404);

        return $page->breadcrumbs([], $competition->name)
            ->setPageTitle($competition->name)
            ->setMetaDescription($competition->meta_description)
            ->setMetaKeywords(explode(',', $competition->meta_keywords))
            ->setSocialImage($competition->first_image)
            ->doNotIndex()
            ->render('modules.competition.competition', compact('competition'));
    }

    public function create(CompetitionInitialEntryRequest $request, Competition $competition): Response|array
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

    public function update(CompetitionAdditionalEntryRequest $request, Competition $competition): Response|bool
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

        return true;
    }
}
