<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Rules;

use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopOrderState;

class ActiveOrder implements Rule
{
    public function passes($attribute, $value)
    {
        $order = ShopOrder::query()->findOrFail($value);

        if (!in_array($order->state_id, [ShopOrderState::STATE_PAID, ShopOrderState::STATE_PRINTED])) {
            return false;
        }

        return true;
    }

    public function message()
    {
        return 'Not a valid order';
    }
}
