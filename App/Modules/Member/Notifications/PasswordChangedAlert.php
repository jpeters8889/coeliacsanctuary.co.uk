<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Notifications\AnonymousNotifiable;

class PasswordChangedAlert extends Notification
{
    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        return (new MJMLMessage())
            ->subject('You changed your password!')
            ->mjml('mailables.mjml.member.password-changed-alert', [
                'date' => Carbon::now(),
                'notifiable' => $notifiable,
                'reason' => 'because you have changed your password on Coeliac Sanctuary.',
                'relatedTitle' => 'Blogs',
                'relatedItems' =>Repository::forEmail(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
