<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRecommendationSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceRecommendedMailable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPlaceRecommendationEmail implements ShouldQueue
{
    public function __construct(private Mailer $email)
    {
    }

    public function handle(PlaceRecommendationSubmitted $placeRecommendation): void
    {
        $this->email->to('contact@coeliacsanctuary.co.uk')
            ->send(new PlaceRecommendedMailable($placeRecommendation->model()));
    }
}
