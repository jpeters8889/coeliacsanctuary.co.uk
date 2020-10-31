<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\PlaceRequest;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest as PlaceRequestModel;

class WhereToEatPlaceRequestController extends BaseController
{
    public function get(Page $page)
    {
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
            ], 'Places Request')
            ->setPageTitle('Place Request Form')
            ->setMetaDescription('Coeliac Sanctuary Place Request | Request a place to be added or removed from the Coeliac Sanctuary gluten free where to eat guide')
            ->setMetaKeywords([
                'reviews', 'places to eat', 'uk places to eat', 'gluten free places to eat uk', 'attractions uk gluten free',
                'gluten free reviews', 'coeliac reviews', 'request a place', 'coeliac requests',
            ])
            ->setSocialImage(asset('assets/images/shares/place-request.jpg'))
            ->render('modules.eating-out.wheretoeat.place-request', [
                'related' => (new ReviewRepository())
                    ->random()
                    ->take(5),
            ]);
    }

    public function create(PlaceRequest $request, Dispatcher $events)
    {
        /** @var PlaceRequestModel $placeRequest */
        $placeRequest = PlaceRequestModel::query()->create([
            'name' => $request->input('name'),
            'addOrRemove' => $request->input('state'),
            'details' => $request->input('comment'),
        ]);

        $events->dispatch(new PlaceRequestSubmitted($placeRequest));

        return new Response(['data' => 'ok']);
    }
}
