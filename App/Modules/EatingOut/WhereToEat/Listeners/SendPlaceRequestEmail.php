<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceRequestMailable as PlaceRequestMailable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPlaceRequestEmail implements ShouldQueue
{
    public function __construct(private Mailer $email)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(PlaceRequestSubmitted $placeRequest): void
    {
        $this->email->to('contact@coeliacsanctuary.co.uk')
            ->send(new PlaceRequestMailable($placeRequest->model()));
    }
}
