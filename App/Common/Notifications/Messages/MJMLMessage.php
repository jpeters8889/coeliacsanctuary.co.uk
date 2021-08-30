<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications\Messages;

use Coeliac\Common\Casts\EmailData;
use Illuminate\Notifications\Messages\MailMessage;
use Spatie\Mailcoach\Domain\TransactionalMail\Mails\Concerns\StoresMail;

class MJMLMessage extends MailMessage
{
    use StoresMail;

    public string $mjml;

    public function mjml(string $view, array|EmailData $data = []): static
    {
        $this->mjml = $this->view = $view;

        $this->markdown = null;

        $this->viewData = (array) $data;

        return $this;
    }
}
