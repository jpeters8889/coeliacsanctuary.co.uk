<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;

class DailyUpdate extends Notification
{
    public function toMail($notifiable = null)
    {
        return (new MJMLMessage())
            ->subject('Your Daily Update')
            ->mjml('mailables.mjml.member.daily-update', [
                'date' => Carbon::now(),
                'notifiable' => $notifiable,
            ]);
    }

    public function via()
    {
        return ['mail'];
    }
}
