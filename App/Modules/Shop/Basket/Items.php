<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Basket;

use Coeliac\Modules\Shop\Exceptions\BasketException;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class Items
{
    private array $request = [
        'product' => null,
        'variant' => null,
        'quantity' => 0,
    ];

    public function __construct(private Basket $basket)
    {
    }

    public function add(ShopProduct $product, ShopProductVariant $variant, int $quantity = 1): void
    {
        $this->request = [
            'product' => $product,
            'variant' => $variant,
            'quantity' => $quantity,
        ];

        $this->validate();

        if (! $this->basket->resolve()) {
            $this->basket->create();
        }

        if ($this->basket->model()->items()->where('product_variant_id', $this->request['variant']->id)->count() > 0) {
            throw new BasketException('This item is already in your basket!');
        }

        $this->basket->model()->addProduct($variant, $quantity);
    }

    public function decreaseQuantity(ShopProduct $product, ShopProductVariant $variant): void
    {
        $this->updateProduct($product, $variant, 'decrease');
    }

    protected function delete(ShopOrderItem $item): void
    {
        $item->variant->increment('quantity', $item->quantity);
        $item->delete();

        $this->basket->model()->touch();
    }

    protected function find(): ?ShopOrderItem
    {
        return $this->basket->model()->items()
            ->where('product_id', $this->request['product']->id)
            ->where('product_variant_id', $this->request['variant']->id)
            ->first();
    }

    public function increaseQuantity(ShopProduct $product, ShopProductVariant $variant): void
    {
        $this->updateProduct($product, $variant);
    }

    protected function updateProduct(ShopProduct $product, ShopProductVariant $variant, string $action = 'increase'): void
    {
        if (! $this->basket->resolve()) {
            throw new BasketException('No basket found');
        }

        $this->request = [
            'product' => $product,
            'variant' => $variant,
            'quantity' => 1,
        ];

        if (! $item = $this->find()) {
            throw new BasketException('Item isn\'t available in your basket');
        }

        if ($action === 'decrease' && $item->quantity === 1) {
            $this->delete($item);

            return;
        }

        if ($action === 'increase') {
            $this->validate();
        }

        $itemMethod = $action === 'increase' ? 'increment' : 'decrement';
        $variantMethod = $action === 'increase' ? 'decrement' : 'increment';

        $item->$itemMethod('quantity');
        $variant->$variantMethod('quantity');

        $this->basket->model()->touch();
    }

    protected function validate(): void
    {
        if (! $this->request['variant']->live) {
            throw new BasketException('This product can\'t be found.');
        }

        if ($this->request['variant']->quantity === 0) {
            throw new BasketException('Sorry, this product is out of stock');
        }

        if ($this->request['quantity'] > $this->request['variant']->quantity) {
            throw new BasketException('Sorry, this product doesn\'t have enough quantity available');
        }
    }
}
