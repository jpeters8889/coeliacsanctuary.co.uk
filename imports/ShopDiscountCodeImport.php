<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;

class ShopDiscountCodeImport extends Import
{
    public function handle()
    {
        $seeds = $this->shopDatabase->table('voucher-codes')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            ShopDiscountCode::query()->create([
                'type_id' => $seed->type + 1,
                'name' => $seed->name,
                'code' => $seed->code,
                'start_at' => Carbon::createFromTimestamp($seed->start),
                'end_at' => Carbon::createFromTimestamp($seed->end),
                'max_claims' => $seed->maxClaims,
                'min_spend' => $seed->minSpend * 100,
                'deduction' => $seed->type === 1 ? $seed->deduction * 100 : $seed->deduction,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
