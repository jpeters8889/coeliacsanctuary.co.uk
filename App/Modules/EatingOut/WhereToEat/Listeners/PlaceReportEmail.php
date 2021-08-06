<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Listeners;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceReportSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceReported;
use Coeliac\Modules\EatingOut\WhereToEat\Mail\PlaceReported as PlaceReportedMailable;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;

class PlaceReportEmail implements ShouldQueue
{
    private Mailer $email;

    public function __construct(Mailer $email)
    {
        $this->email = $email;
    }

    /**
     * Handle the event.
     */
    public function handle(PlaceReportSubmitted $placeReport)
    {
        $this->email->to('contact@coeliacsanctuary.co.uk')
            ->send(new PlaceReportedMailable($placeReport->model()));
    }
}