<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceRequest as PlaceRequestMailable;

class PlaceRequestEmail implements ShouldQueue
{
    private Mailer $email;

    public function __construct(Mailer $email)
    {
        $this->email = $email;
    }

    /**
     * Handle the event.
     */
    public function handle(PlaceRequestSubmitted $placeRequest)
    {
        $this->email->to('contact@coeliacsanctuary.co.uk')
            ->send(new PlaceRequestMailable($placeRequest->model()));
    }
}
