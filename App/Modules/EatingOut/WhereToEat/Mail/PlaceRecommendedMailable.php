<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Mail;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRecommendation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PlaceRecommendedMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var WhereToEatRecommendation
     */
    public $placeRecommendation;

    /**
     * Create a new message instance.
     */
    public function __construct(WhereToEatRecommendation $placeRecommendation)
    {
        $this->placeRecommendation = $placeRecommendation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Place Recommendation')
            ->view('mailables.plain.place-recommendation');
    }
}
