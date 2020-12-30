<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Items;

use Coeliac\Modules\Shop\Models\ShopProduct as ProductModel;

class ShopProduct extends Item
{
    public function toArray(): array
    {
        /** @var ProductModel $product */
        $product = $this->collectionItem->item;

        return [
            'type' => 'product',
            'id' => $product->id,
            'title' => $product->title,
            'description' => $product->meta_description,
            'long_description' => $product->description,
            'created_at' => $product->created_at,
            'image' => $product->main_image,
        ];
    }

    public function render(): string
    {
        return $this->viewFactory->make('modules.collections.items.product', [
            'product' => $this->collectionItem->item,
            'description' => $this->collectionItem->description,
        ])->render();
    }
}
