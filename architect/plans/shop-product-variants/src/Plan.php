<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\ShopProductVariants;

use Illuminate\Database\Eloquent\Model;
use Coeliac\Modules\Shop\Models\ShopProduct;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public bool $deferUpdate = true;

    public function vuePrefix(): string
    {
        return 'shop-product-variants';
    }

    public function handleUpdate(Model $model, $column, $value)
    {
        /** @var ShopProduct $model */
        $variants = json_decode($value, true);

        foreach ($variants['update'] as $variant) {
            $model->variants()->find($variant['id'])->update([
                'title' => $variant['title'],
                'weight' => $variant['weight'],
                'quantity' => $variant['quantity'],
            ]);
        }

        foreach ($variants['add'] as $variant) {
            $model->variants()->create([
                'title' => $variant['title'],
                'weight' => $variant['weight'],
                'quantity' => $variant['quantity'],
            ]);
        }
    }
}
