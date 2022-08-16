<?php

namespace Coeliac\Modules\Shop\Rules;

use Coeliac\Modules\Shop\Models\ShopOrderReviewInvitation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;

class ReviewedProductIsInOrder implements Rule
{
    public function passes($attribute, $value)
    {
        /** @var ShopOrderReviewInvitation $invitation */
        $invitation = app(Request::class)->route('invitation');

        $products = $invitation->order->items->pluck('product_id')->values()->toArray();

        return in_array((int)$value, $products, true);
    }

    public function message()
    {
        return 'This product isnt in your order';
    }
}
