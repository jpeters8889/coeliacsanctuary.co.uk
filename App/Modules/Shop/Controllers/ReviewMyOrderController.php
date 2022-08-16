<?php

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Shop\Models\ShopOrderReview;
use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Coeliac\Modules\Shop\Models\ShopSource;
use Coeliac\Modules\Shop\Requests\ReviewMyOrderRequest;

class ReviewMyOrderController extends BaseController
{
    public function get(ShopOrderReviewInvitation $invitation, Page $page)
    {
        abort_if($invitation->review()->count() > 0, 404);

        return $page->doNotIndex()
            ->breadcrumbs([['link' => '/shop', 'title' => 'Shop']], 'Review My Order')
            ->setPageTitle('Review My Order')
            ->render('modules.shop.review-my-order', [
                'id' => $invitation->order->order_key,
                'invitation' => $invitation->id,
                'name' => $invitation->order->user->name,
                'products' => $invitation->order->items->pluck('product_id'),
            ]);
    }

    public function create(ShopOrderReviewInvitation $invitation, ReviewMyOrderRequest $request)
    {
        abort_if($invitation->review()->count() > 0, 404);

        collect($request->input('whereHeard'))
            ->map(fn (string $source) => ShopSource::query()->firstOrCreate(['source' => $source]))
            ->each(fn (ShopSource $source) => $source->orders()->attach($invitation->order));

        /** @var ShopOrderReview $review */
        $review = $invitation->review()->create([
            'order_id' => $invitation->order_id,
            'name' => $request->input('name')
        ]);

        collect($request->input('products'))->each(fn (array $product) => $review->products()->create([
            'product_id' => $product['id'],
            'order_id' => $invitation->order_id,
            'rating' => $product['rating'],
            'review' => $product['review'],
        ]));

        return ['data' => 'done'];
    }
}
