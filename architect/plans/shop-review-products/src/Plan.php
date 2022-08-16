<?php

namespace Coeliac\Architect\Plans\ShopReviewProducts;

use JPeters\Architect\Plans\Plan as ArchitectPlan;
use Illuminate\Database\Eloquent\Model;

class Plan extends ArchitectPlan
{
    public bool $deferUpdate = true;

    public function vuePrefix(): string
    {
        return 'shop-review-products';
    }

    public function handleUpdate(Model $model, $column, $value, $index = null)
    {
        collect(json_decode($value, true))
            ->each(function (array $review) use ($model) {
                if ($review['id']) {
                    $model->products->find($review['id'])->update([
                        'product_id' => $review['product_id'],
                        'rating' => $review['rating'],
                        'review' => $review['review'],
                    ]);

                    return;
                }

                $model->products()->create([
                    'product_id' => $review['product_id'],
                    'rating' => $review['rating'],
                    'review' => $review['review'],
                ]);
            });
    }
}
