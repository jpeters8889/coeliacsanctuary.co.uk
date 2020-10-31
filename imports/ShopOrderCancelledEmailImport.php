<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Common\Models\NotificationEmail;
use Coeliac\Modules\Shop\Notifications\OrderCancelledNotification;

class ShopOrderCancelledEmailImport extends Import
{
    public function handle()
    {
        $seeds = $this->campaignDatabase
            ->table('sent_transactional')
            ->where('template', 'orderCancelled')
            ->get();

        $bar = $this->command->makeProgressBar(count($seeds));

        $bar->start();

        foreach ($seeds as $seed) {
            if (!$order = $this->resolveOrder($seed)) {
                $bar->advance();
                continue;
            }

            if (!$order->user) {
                $bar->advance();
                continue;
            }

            $notification = new OrderCancelledNotification($order);
            $notification->forceDate(Carbon::createFromFormat('d/m/Y', json_decode($seed->mergeTags, true)['header']['date']));

            NotificationEmail::query()->create([
                'key' => $seed->token,
                'user_id' => $order->user->id,
                'email_address' => $seed->toEmail,
                'template' => $notification->toMail($order->user)->mjml,
                'data' => $notification->toMail($order->user)->viewData,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }
    }

    private function resolveOrder($seed): ?ShopOrder
    {
        $data = json_decode($seed->mergeTags, true);

        return ShopOrder::query()
            ->with(['items', 'user', 'address'])
            ->where('order_key', $data['order_id'])
            ->first();
    }
}
