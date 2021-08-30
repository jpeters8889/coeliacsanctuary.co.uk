<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRecommendationSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRecommendation;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Coeliac\Modules\EatingOut\WhereToEat\Requests\RecommendAPlaceRequest;
use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Base\Controllers\BaseController;

class WhereToEatRecommendAPlaceController extends BaseController
{
    public function get(Page $page): Response
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
                'venueTypes' => WhereToEatVenueType::query()
                    ->orderBy('venue_type')
                    ->get()
                    ->transform(fn (WhereToEatVenueType $venueType) => [
                        'value' => $venueType->id,
                        'label' => $venueType->venue_type,
                    ]),
            ]);
    }

    public function create(RecommendAPlaceRequest $request, Dispatcher $events): Response
    {
        /** @var WhereToEatRecommendation $recommendation */
        $recommendation = WhereToEatRecommendation::query()->create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'place_name' => $request->input('place_name'),
            'place_location' => $request->input('place_location'),
            'place_web_address' => $request->input('place_web_address'),
            'place_venue_type_id' => $request->input('place_venue_type_id'),
            'place_details' => $request->input('place_details'),
        ]);

        $events->dispatch(new PlaceRecommendationSubmitted($recommendation));

        return new Response(['data' => 'ok']);
    }
}
