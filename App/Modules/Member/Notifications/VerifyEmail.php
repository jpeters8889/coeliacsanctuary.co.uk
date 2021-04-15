<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Notifications;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class VerifyEmail extends Notification
{
    private bool $newUser;

    public function __construct($newUser = true)
    {
        $this->newUser = $newUser;
    }

    public function toMail($notifiable = null)
    {
        $subject = 'Thanks for registering, please confirm your email address!';

        if (!$this->newUser) {
            $subject = 'Please confirm your email address!';
        }

        return (new MJMLMessage())
            ->subject($subject)
            ->mjml('mailables.mjml.member.verify-email', [
                'date' => Carbon::now(),
                'notifiable' => $notifiable,
                'reason' => 'because you registed an account at Coeliac Sanctuary and need to confirm your email address.',
                'newUser' => $this->newUser,
                'verification_link' => $notifiable->generateEmailVerificationLink(),
                'relatedTitle' => 'Blogs',
                'relatedItems' => (new Repository())->random()->take(3)
                    ->transform(static function (Blog $blog) {
                        return [
                            'id' => $blog->id,
                            'title' => $blog->title,
                            'link' => Container::getInstance()->make(ConfigRepository::class)->get('app.url').$blog->link,
                            'image' => $blog->main_image,
                        ];
                    }),
            ]);
    }

    public function via()
    {
        return ['mail'];
    }
}
