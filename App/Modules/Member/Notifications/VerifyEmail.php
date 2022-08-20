<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class VerifyEmail extends Notification
{
    public function __construct(protected bool $newUser = true)
    {
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        $subject = 'Thanks for registering, please confirm your email address!';

        if (! $this->newUser) {
            $subject = 'Please confirm your email address!';
        }

        /** @var User $notifiable */
        return (new MJMLMessage())
            ->subject($subject)
            ->mjml('mailables.mjml.member.verify-email', [
                'date' => Carbon::now(),
                'notifiable' => $notifiable,
                'reason' => 'because you registered an account at Coeliac Sanctuary and need to confirm your email address.',
                'newUser' => $this->newUser,
                'verification_link' => $notifiable->generateEmailVerificationLink(),
                'relatedTitle' => 'Blogs',
                'relatedItems' => Repository::forEmail(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
