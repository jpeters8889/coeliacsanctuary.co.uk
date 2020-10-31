<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Listeners;

use Illuminate\Support\Str;
use Coeliac\Modules\Shop\Events\CreateOrder;
use Coeliac\Modules\Shop\Models\ShopPaymentType;
use Coeliac\Modules\Shop\Notifications\OrderCreatedNotification;

class OrderCreated
{
    private ?CreateOrder $order = null;

    public function handle(CreateOrder $order)
    {
        $this->order = $order;

        $this->order->model()->setPubllicKey();

        $this->updateOrder();

        $this->order->model()->markAsPaid();

        $this->sendEmails();
    }

    protected function sendEmails()
    {
        $notification = new OrderCreatedNotification($this->order->model());

        $this->order->model()->user->notify($notification);
        admin_user()->notify($notification);
    }

    private function updateOrder()
    {
        $subtotal = array_sum($this->order->model()->items->pluck('subtotal')->toArray());
        $discount = 0;

        if ($this->order->discountCode()) {
            $discount = $this->order->discountCode()->calculateDeduction($subtotal);
        }

        $this->order->model()->payment()->create([
            'subtotal' => $subtotal,
            'discount' => $discount,
            'postage' => $postage = $this->order->postage(),
            'total' => $subtotal - $discount + $postage,
            'payment_type_id' => ShopPaymentType::query()->where('type', Str::ucfirst($this->order->paymentMethod()))->first()->id,
        ])->response()->create([
            'response' => $this->order->paymentResponse(),
        ]);

        if ($this->order->discountCode()) {
            $this->order->discountCode()->associateOrder(
                $this->order->model(),
                $discount,
            );
        }
    }
}
