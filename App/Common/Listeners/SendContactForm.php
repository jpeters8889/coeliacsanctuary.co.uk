<?php

declare(strict_types=1);

namespace Coeliac\Common\Listeners;

use Coeliac\Common\Mail\ContactUs;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Coeliac\Common\Events\ContactFormSubmitted;

class SendContactForm implements ShouldQueue
{
    private Mailer $email;

    public function __construct(Mailer $email)
    {
        $this->email = $email;
    }

    public function handle(ContactFormSubmitted $event)
    {
        $this->email->to('contact@coeliacsanctuary.co.uk')
            ->send(new ContactUs($event->request()));
    }
}
