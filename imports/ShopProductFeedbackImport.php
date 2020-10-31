<?php

declare(strict_types=1);

namespace Imports;

use Coeliac\Modules\Shop\Models\ShopProduct;

class ShopProductFeedbackImport extends Import
{
    public function handle()
    {
        $seeds = $this->shopDatabase->table('feedback')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            $oldProduct = $this->shopDatabase->table('products')->where('id', $seed->item)->first();

            ShopProduct::query()->where('slug', $oldProduct->alias)->first()
                ->feedback()->create([
                    'name' => $seed->name,
                    'feedback' => $seed->feedback,
                ]);

            $bar->advance();
        }

        $bar->finish();
    }
}
