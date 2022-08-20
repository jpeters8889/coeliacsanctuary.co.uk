<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\ProductRepository;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Routing\UrlGenerator;

class LeaveAReviewNotification extends Notification
{
    public function __construct(protected ShopOrderReviewInvitation $invitation)
    {
        //
    }

    protected function buildReviewLink(User $user): string
    {
        return resolve(UrlGenerator::class)->temporarySignedRoute(
            'shop.review-order',
            Carbon::now()->addMonths(6),
            [
                'invitation' => $this->invitation,
                'hash' => sha1($user->email),
            ]
        );
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        return (new MJMLMessage())
            ->subject('Coeliac Sanctuary - Review Your Purchase')
            ->mjml('mailables.mjml.shop.leave-a-review', [
                'date' => Carbon::now(),
                'key' => $this->key,
                'order' => $this->invitation->order,
                'reviewLink' => $this->buildReviewLink($notifiable),
                'notifiable' => $notifiable,
                'reason' => 'to invite you to leave feedback on your recent purchase.',
                'relatedTitle' => 'Products',
                'relatedItems' => (new ProductRepository())->random()->take(3)
                    ->transform(static function (ShopProduct $product) {
                        return [
                            'id' => $product->id,
                            'title' => $product->title,
                            'link' => Container::getInstance()->make(Repository::class)->get('app.url').$product->link,
                            'image' => $product->first_image,
                        ];
                    }),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
