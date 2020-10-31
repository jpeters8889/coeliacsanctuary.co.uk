<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;

class ShopBasketImport extends Import
{
    public function handle()
    {
        $seeds = $this->shopDatabase->table('basket')->get();

        $bar = $this->command->makeProgressBar($seeds->count());
        $bar->start();

        foreach ($seeds as $seed) {
            $state = ShopOrderState::STATE_BASKET;

            if ($seed->converted) {
                $state = ShopOrderState::STATE_PAID;
            }

            if ($seed->expired) {
                $state = ShopOrderState::STATE_EXPIRED;
            }

            ShopOrder::query()->create([
                'state_id' => $state,
                'token' => $seed->token,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
