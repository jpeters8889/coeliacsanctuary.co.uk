<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Mail;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatPlaceReport;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlaceReportMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var WhereToEatPlaceReport
     */
    public $placeReport;

    /**
     * Create a new message instance.
     */
    public function __construct(WhereToEatPlaceReport $placeReport)
    {
        $this->placeReport = $placeReport;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Where To Eat Place Reported')
            ->view('mailables.plain.place-report');
    }
}
