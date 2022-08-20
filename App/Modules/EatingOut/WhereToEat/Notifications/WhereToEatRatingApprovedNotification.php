<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Notifications\AnonymousNotifiable;

class WhereToEatRatingApprovedNotification extends Notification
{
    private WhereToEatReview $rating;

    public function __construct(WhereToEatReview $rating)
    {
        $this->rating = $rating;
        $this->date = Carbon::now();
    }

    public function rating(): WhereToEatReview
    {
        return $this->rating;
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
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
                'relatedItems' => Repository::forEmail(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
