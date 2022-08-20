<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceReportSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceReportMailable as PlaceReportedMailable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPlaceReportEmail implements ShouldQueue
{
    public function __construct(private Mailer $email)
    {
    }

    /**
     * Handle the event.
     */
    public function handle(PlaceReportSubmitted $placeReport): void
    {
        $this->email->to('contact@coeliacsanctuary.co.uk')
            ->send(new PlaceReportedMailable($placeReport->model()));
    }
}
