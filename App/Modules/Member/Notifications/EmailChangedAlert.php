<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Notifications\AnonymousNotifiable;

class EmailChangedAlert extends Notification
{
    private User $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        return (new MJMLMessage())
            ->subject('You changed your email address!')
            ->mjml('mailables.mjml.member.email-changed-alert', [
                'date' => Carbon::now(),
                'notifiable' => $this->user,
                'reason' => 'because you have changed your email address on Coeliac Sanctuary.',
                'relatedTitle' => 'Blogs',
                'relatedItems' => Repository::forEmail(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
