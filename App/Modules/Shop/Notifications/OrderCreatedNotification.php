<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Notifications;

use Carbon\Carbon;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Support\NotificationRelatedProducts;
use Illuminate\Notifications\AnonymousNotifiable;

class OrderCreatedNotification extends Notification
{
    public ShopOrder $order;

    public function __construct(ShopOrder $order)
    {
        $this->order = $order;
    }

    public function toMail(User|AnonymousNotifiable|null $notifiable = null): MJMLMessage
    {
        return (new MJMLMessage())
            ->subject('Coeliac Sanctuary - Order Confirmed')
            ->mjml('mailables.mjml.shop.order-confirmation', [
                'date' => Carbon::now(),
                'key' => $this->key,
                'order' => $this->order,
                'notifiable' => $notifiable,
                'reason' => 'as confirmation to an order placed in the Coeliac Sanctuary Shop.',
                'relatedTitle' => 'Products',
                'relatedItems' => NotificationRelatedProducts::get(),
            ]);
    }

    public function via(): array
    {
        return ['mail'];
    }
}
