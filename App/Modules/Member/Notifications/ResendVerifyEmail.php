<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class ResendVerifyEmail extends Notification
{
    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        /** @var User $notifiable */

        return (new MJMLMessage())
            ->subject('Verify your email address')
            ->mjml('mailables.mjml.member.resend-verify-email', [
                'date' => Carbon::now(),
                'notifiable' => $notifiable,
                'reason' => 'because you registered an account at Coeliac Sanctuary and need to confirm your email address.',
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
