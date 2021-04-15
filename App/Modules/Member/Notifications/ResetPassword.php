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

class ResetPassword extends Notification
{
    private string $resetUrl;

    public function __construct(string $resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    public function toMail($notifiable = null)
    {
        return (new MJMLMessage())
            ->subject('Reset Your password!')
            ->mjml('mailables.mjml.member.reset-password', [
                'date' => Carbon::now(),
                'reset_url' => $this->resetUrl,
                'notifiable' => $notifiable,
                'reason' => 'because you have want to reset your password on Coeliac Sanctuary.',
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

    public function resetUrl(): string
    {
        return $this->resetUrl;
    }

    public function via()
    {
        return ['mail'];
    }
}
