<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRecommendationSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceRecommendedMailable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceRequestMailable as PlaceRequestMailable;

class SendPlaceRecommendationEmail implements ShouldQueue
{
    private Mailer $email;

    public function __construct(Mailer $email)
    {
        $this->email = $email;
    }

    public function handle(PlaceRecommendationSubmitted $placeRecommendation)
    {
        $this->email->to('contact@coeliacsanctuary.co.uk')
            ->send(new PlaceRecommendedMailable($placeRecommendation->model()));
    }
}
