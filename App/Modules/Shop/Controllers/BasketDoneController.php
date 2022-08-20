<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Response\ShopPage;
use Illuminate\Http\Response;
use Illuminate\Session\Store as SessionStore;

class BasketDoneController extends BaseController
{
    public function show(ShopPage $page, SessionStore $store): Response
    {
        /** @var ShopOrder $order */
        $order = ShopOrder::query()
            ->where('token', $store->get('basket_token'))
            ->with(['payment', 'items', 'user'])
            ->first();

        $gtagData = [
            'transaction_id' => $order->order_key,
            'value' => $order->payment->subtotal / 100,
            'currency' => 'GBP',
            'shipping' => $order->payment->postage / 100,
            'tax' => 0,
            'affiliation' => 'Coeliac Sanctuary',
            'items' => $order->items->transform(fn (ShopOrderItem $item) => [
                'id' => $item->product_id,
                'sku' => "{$item->product_id} - {$item->product_variant_id}",
                'name' => $item->product_title,
                'variant' => $item->product_variant_id,
                'quantity' => $item->quantity,
                'price' => $item->product_price / 100,
            ])->toArray(),
        ];

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
                'order' => $order,
                'gtagData' => $gtagData,
                'latestBlogs' => (new BlogRepository())->take(2),
                'latestReviews' => (new ReviewRepository())->take(2),
                'latestRecipes' => (new RecipeRepository())->take(3),
            ]);
    }
}
