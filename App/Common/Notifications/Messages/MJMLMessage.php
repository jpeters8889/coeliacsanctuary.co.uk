<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;
use Spatie\Mailcoach\Domain\TransactionalMail\Mails\Concerns\StoresMail;

class MJMLMessage extends MailMessage
{
    use StoresMail;

    public $mjml;

    public function mjml($view, array $data = [])
    {
        $this->mjml = $this->view = $view;

        $this->markdown = null;

        $this->viewData = $data;

        return $this;
    }
}
