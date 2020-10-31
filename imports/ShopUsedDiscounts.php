<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopDiscountCodesUsed;

class ShopUsedDiscounts extends Import
{
    public function handle()
    {
        $seeds = $this->shopDatabase->table('voucher-used')->get();

        $bar = $this->command->makeProgressBar($seeds->count());
        $bar->start();

        foreach ($seeds as $seed) {
            $legacyVoucher = $this->shopDatabase->table('voucher-codes')
                ->where('id', $seed->vID)
                ->first();

            $legacyOrder = $this->shopDatabase->table('orders')
                ->where('id', $seed->oID)
                ->first();

            if (!$legacyVoucher || !$legacyOrder) {
                $bar->advance();
                continue;
            }

            /** @var ShopDiscountCode $discount */
            $discount = ShopDiscountCode::query()
                ->where('code', $legacyVoucher->code)
                ->first();

            /** @var ShopOrder $order */
            $order = ShopOrder::query()
                ->where('order_key', $legacyOrder->publicID)
                ->first();

            if (!$discount || !$order) {
                $bar->advance();
                continue;
            }

            ShopDiscountCodesUsed::query()
                ->create([
                    'discount_id' => $discount->id,
                    'order_id' => $order->id,
                    'discount_amount' => $seed->amount * 100,
                    'created_at' => $order->payment->created_at,
                    'updated_at' => $order->payment->updated_at,
                ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
