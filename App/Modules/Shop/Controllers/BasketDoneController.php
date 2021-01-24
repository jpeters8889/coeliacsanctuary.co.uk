<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Response\ShopPage;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Session\Store as SessionStore;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;

class BasketDoneController extends BaseController
{
    public function show(ShopPage $page, SessionStore $store)
    {
        sleep(1);

        /** @var ShopOrder $order */
        $order = ShopOrder::query()
            ->where('token', $store->get('basket_token'))
            ->with(['payment', 'items'])
            ->first();

        $gtagData = [
            'transaction_id' => $order->order_key,
            'value' => $order->payment->subtotal / 100,
            'currency' => 'GBP',
            'shipping' => $order->payment->postage / 100,
            'items' => $order->items()->get()->transform(function (ShopOrderItem $item) {
                return [
                    'id' => $item->product_id,
                    'sku' => "{$item->product_id} - {$item->product_variant_id}",
                    'name' => $item->product_title,
                    'variant' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product_price / 100,
                ];
            })->toArray(),
        ];

//        $store->remove('basket_token');

        return $page
            ->breadcrumbs([
                [
                    'link' => '/shop',
                    'title' => 'Shop',
                ],
            ], 'Order Complete!')
            ->setPageTitle('Order Complete | Coeliac Sanctuary')
            ->doNotIndex()
            ->render('modules.shop.basket-done', [
                'gtagData' => $gtagData,
                'latestBlogs' => (new BlogRepository())->take(2),
                'latestReviews' => (new ReviewRepository())->take(2),
                'latestRecipes' => (new RecipeRepository())->take(3),
            ]);
    }
}
