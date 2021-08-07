<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest as PlaceRequestModel;

class PlaceRequestMailable extends Mailable
{
    use Queueable;
    use SerializesModels;

    /**
     * @var PlaceRequestModel
     */
    public $placeRequest;

    /**
     * Create a new message instance.
     */
    public function __construct(PlaceRequestModel $placeRequest)
    {
        $this->placeRequest = $placeRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Place Request')
            ->view('mailables.plain.place-request');
    }
}
