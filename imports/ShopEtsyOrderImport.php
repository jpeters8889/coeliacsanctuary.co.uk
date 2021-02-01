<?php

declare(strict_types=1);

namespace Imports;

use Carbon\Carbon;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopPostageCountry;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopEtsyOrderImport extends Import
{
    public function handle()
    {
        $seeds = $this->shopDatabase->table('orders')
            ->where('basketID', 0)
            ->get();

        $bar = $this->command->makeProgressBar($seeds->count());
        $bar->start();

        foreach ($seeds as $seed) {
            /** @var ShopOrder $order */
            $order = ShopOrder::query()->create([
                'state_id' => ShopOrderState::STATE_COMPLETE,
                'postage_country_id' => 1,
                'token' => '',
                'order_key' => $seed->publicID,
                'shipped_at' => Carbon::createFromTimestamp($seed->shipped),
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            $items = json_decode($seed->items, true);

            if (!$items) {
                $this->command->warn("Order {$order->id} has no items");
                $bar->advance();
                continue;
            }

            foreach ($items as $item) {
                $item = $this->formatItem($item, $seed);

                if ($item === []) {
                    continue;
                }

                $order->items()->create($item);
            }

            $this->createPaymentInfo($seed, $order);

            $this->createUserAndAddresses($seed, $order);

            $order->update(['updated_at' => $seed->updated_at]);

            $bar->advance();
        }

        $bar->finish();
    }

    protected function formatItem($item, $seed): array
    {
        if (isset($item['itemID'])) {
            return $this->makeRowFromLegacy($item, $seed);
        }

        return $this->makeRow($item, $seed);
    }

    protected function makeRowFromLegacy($item, $seed): array
    {
        $oldProduct = $this->shopDatabase->table('products')
            ->where('id', $item['itemID'])
            ->first();

        /** @var ShopProduct $product */
        $product = ShopProduct::query()
            ->where('slug', $oldProduct->alias)
            ->first();

        /** @var ShopProductVariant $variant */
        $variant = $product->variants[0];

        return [
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => abs($item['quantity']),
            'product_title' => $item['itemDesc'],
            'product_price' => $item['totalPrice'] * 100,
            'created_at' => $seed->created_at,
            'updated_at' => $seed->updated_at,
        ];
    }

    protected function makeRow($item, $seed): array
    {
        /** @var ShopProduct $product */
        $product = ShopProduct::query()
            ->where('slug', $item['alias'])
            ->first();

        if (!$product) {
            return [];
        }

        /** @var ShopProductVariant $variant */
        $variant = $product->variants()
            ->where('title', strtolower($item['size']))
            ->first();

        $title = $item['title'];

        if ($item['size'] !== '') {
            $title .= " ({$item['size']})";
        }

        return [
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'quantity' => abs($item['quantity']),
            'product_title' => $title,
            'product_price' => $item['price'] * 100,
            'created_at' => $seed->created_at,
            'updated_at' => $seed->updated_at,
        ];
    }

    /**
     * @param $seed
     */
    protected function createPaymentInfo($seed, ShopOrder $order): void
    {
        $payment = json_decode($seed->totals, true);

        foreach ($payment as $key => $value) {
            $payment[$key] = str_replace(' ', '', $value);
        }

        $order->payment()->create([
            'subtotal' => ($payment['subtotal'] ?? 0) * 100,
            'discount' => ($payment['discount'] ?? 0) * 100,
            'postage' => ($payment['postage'] ?? 0) * 100,
            'total' => ($payment['total'] ?? 0) * 100,
            'payment_type_id' => 3,
            'created_at' => $seed->created_at,
            'updated_at' => $seed->updated_at,
        ]);

        $order->fresh()->payment->response()->create([
            'response' => $seed->response,
            'created_at' => $seed->created_at,
            'updated_at' => $seed->updated_at,
        ]);
    }

    /**
     * @param $seed
     */
    protected function createUserAndAddresses($seed, ShopOrder $order): void
    {
        $billingAddress = json_decode($seed->billing, true);
        $shippingAddress = json_decode($seed->shipping, true);

        if (!$billingAddress) {
            $billingAddress = $shippingAddress['address'];
            $billingAddress['name'] = $shippingAddress['name'];
        }

        if (isset($billingAddress['address'])) {
            $name = $billingAddress['name'];

            $billingAddress = $billingAddress['address'];
            $billingAddress['name'] = $name;
        }

        /** @var User $user */
        $user = User::query()->firstOrCreate(['email' => $shippingAddress['email']], [
            'name' => $billingAddress['name'],
            'phone' => $shippingAddress['phone'],
            'created_at' => $seed->created_at,
            'updated_at' => $seed->updated_at,
        ]);

        $user->addresses()->firstOrCreate([
            'type' => 'Billing',
            'name' => $billingAddress['name'],
            'line_1' => $billingAddress['line1'],
            'line_2' => $billingAddress['line2'],
            'line_3' => $billingAddress['line3'],
            'town' => $billingAddress['town'],
            'postcode' => $billingAddress['postcode'],
            'country' => $billingAddress['country'],
        ], [
            'created_at' => $seed->created_at,
            'updated_at' => $seed->updated_at,
        ]);

        /** @var UserAddress $shipping */
        $shipping = $user->addresses()->firstOrCreate([
            'type' => 'Shipping',
            'name' => $shippingAddress['name'],
            'line_1' => $shippingAddress['address']['line1'],
            'line_2' => $shippingAddress['address']['line2'],
            'line_3' => $shippingAddress['address']['line3'],
            'town' => $shippingAddress['address']['town'],
            'postcode' => $shippingAddress['address']['postcode'],
            'country' => $shippingAddress['address']['country'],
        ], [
            'created_at' => $seed->created_at,
            'updated_at' => $seed->updated_at,
        ]);

        $order->update([
            'user_id' => $user->id,
            'user_address_id' => $shipping->id,
            'postage_country_id' => ShopPostageCountry::query()
                    ->firstWhere('country', $shippingAddress['address']['country'])
                    ->id ?? 1,
        ]);
    }
}
