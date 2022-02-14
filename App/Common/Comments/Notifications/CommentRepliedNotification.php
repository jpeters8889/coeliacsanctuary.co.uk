<?php

declare(strict_types=1);

namespace Coeliac\Common\Comments\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Models\Comment;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Models\CommentReply;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Illuminate\Notifications\AnonymousNotifiable;

class CommentRepliedNotification extends Notification
{
    private Comment $comment;

    private CommentReply $commentReply;

    public function __construct(Comment $comment, CommentReply $commentReply)
    {
        $this->comment = $comment;
        $this->commentReply = $commentReply;
    }

    public function comment(): Comment
    {
        return $this->comment;
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        return (new MJMLMessage())
            ->subject('Coeliac Sanctuary - A Reply has been left on your Comment')
            ->mjml('mailables.mjml.comments.replied', [
                'date' => $this->date ?: Carbon::now(),
                'email' => $this->comment->email,
                'key' => $this->key,
                'comment' => $this->comment,
                'reply' => $this->commentReply,
                'reason' => 'to alert you that a comment that you had left on our website has been replied to.',
                'relatedTitle' => 'Blogs',
                'relatedItems' => Repository::forEmail(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
