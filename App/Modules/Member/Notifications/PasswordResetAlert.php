<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class PasswordResetAlert extends Notification
{
    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        return (new MJMLMessage())
            ->subject('You\'ve reset your password!')
            ->mjml('mailables.mjml.member.password-reset-alert', [
                'date' => Carbon::now(),
                'notifiable' => $notifiable,
                'reason' => 'because you have reset your password on Coeliac Sanctuary.',
                'relatedTitle' => 'Blogs',
                'relatedItems' => Repository::forEmail(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
