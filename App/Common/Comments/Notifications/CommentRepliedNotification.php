<?php

declare(strict_types=1);

namespace Coeliac\Common\Comments\Notifications;

use Coeliac\Common\Models\User;
use Coeliac\Common\Models\Comment;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Models\CommentReply;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class CommentRepliedNotification extends Notification
{
    private Comment $comment;

    private CommentReply $commentReply;

    public function __construct(Comment $comment, CommentReply $commentReply)
    {
        $this->comment = $comment;
        $this->commentReply = $commentReply;
    }

    public function comment()
    {
        return $this->comment;
    }

    public function toMail(User $notifiable = null)
    {
        return (new MJMLMessage())
            ->subject('Coeliac Sanctuary - A Reply has been left on your Comment')
            ->mjml('mailables.mjml.comments.replied', [
                'date' => $this->date,
                'email' => $this->comment->email,
                'key' => $this->key,
                'comment' => $this->comment,
                'reply' => $this->commentReply,
                'reason' => 'to alert you that a comment that you had left on our website has been replied to.',
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
