<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Notifications;

use Carbon\Carbon;
use Illuminate\Container\Container;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\ProductRepository;
use Illuminate\Contracts\Config\Repository;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Common\Notifications\Notification;
use Coeliac\Common\Notifications\Messages\MJMLMessage;

class OrderCancelledNotification extends Notification
{
    public ShopOrder $order;

    public function __construct(ShopOrder $order)
    {
        $this->order = $order;
    }

    public function toMail($notifiable = null)
    {
        return (new MJMLMessage())
            ->subject('Coeliac Sanctuary - Order Cancelled')
            ->mjml('mailables.mjml.shop.order-cancelled', [
                'date' => Carbon::now(),
                'key' => $this->key,
                'order' => $this->order,
                'notifiable' => $notifiable,
                'reason' => 'as confirmation that your Coeliac Sanctuary order has been cancelled.',
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

    public function via()
    {
        return ['mail'];
    }
}
