<?php

declare(strict_types=1);

namespace Coeliac\Common\Comments\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Models\Comment;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Notifications\AnonymousNotifiable;

class CommentApprovedNotification extends Notification
{
    private Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->date = Carbon::now();
    }

    public function comment(): Comment
    {
        return $this->comment;
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        return (new MJMLMessage())
            ->subject('Coeliac Sanctuary - Comment Approved')
            ->mjml('mailables.mjml.comments.approved', [
                'date' => $this->date,
                'email' => $this->comment->email,
                'key' => $this->key,
                'comment' => $this->comment,
                'reason' => 'to alert you that a comment that you had left on our website has been approved.',
                'relatedTitle' => 'Blogs',
                'relatedItems' => Repository::forEmail(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
