<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Models\User;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Illuminate\Contracts\Config\Repository as ConfigRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;

class WhereToEatRatingApprovedNotification extends Notification
{
    private WhereToEatRating $rating;

    public function __construct(WhereToEatRating $rating)
    {
        $this->rating = $rating;
        $this->date = Carbon::now();
    }

    public function rating()
    {
        return $this->rating;
    }

    public function toMail($notifiable = null)
    {
        return (new MJMLMessage())
            ->subject('Coeliac Sanctuary - Place Review Approved')
            ->mjml('mailables.mjml.wheretoeat.approved', [
                'date' => $this->date,
                'email' => $this->rating->email,
                'key' => $this->key,
                'rating' => $this->rating,
                'reason' => 'to alert you that a review that you had left on an eatery on our website has been approved.',
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
