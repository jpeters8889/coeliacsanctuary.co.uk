<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications\Messages;

use Illuminate\Notifications\Messages\MailMessage;

class MJMLMessage extends MailMessage
{
    public $mjml;

    public function mjml($view, array $data = [])
    {
        $this->mjml = $this->view = $view;

        $this->markdown = null;

        $this->viewData = $data;

        return $this;
    }
}
