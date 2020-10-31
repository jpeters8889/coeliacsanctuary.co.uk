<?php

declare(strict_types=1);

namespace Coeliac\Common\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ContactUs extends Mailable
{
    use Queueable;
    use SerializesModels;

    private array $contactRequest;

    public function __construct(array $contactRequest)
    {
        $this->contactRequest = $contactRequest;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('New Contact Form - '.$this->contactRequest['subject'])
            ->replyTo($this->contactRequest['email'])
            ->view('mailables.plain.contact', ['request' => $this->contactRequest]);
    }
}
