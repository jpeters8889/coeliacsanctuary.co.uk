<?php

declare(strict_types=1);

namespace Coeliac\Common\Comments\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Models\User;
use Coeliac\Common\Models\Comment;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class CommentApprovedNotification extends Notification
{
    private Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
        $this->date = Carbon::now();
    }

    public function comment()
    {
        return $this->comment;
    }

    public function toMail($notifiable = null)
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
