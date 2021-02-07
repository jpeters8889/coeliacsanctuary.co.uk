<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Contracts\Auth\Access\Gate;

class ViewOrderRequest extends ApiFormRequest
{
    protected ShopOrder $order;

    public function authorize(Gate $gate)
    {
        $this->order = ShopOrder::query()
            ->where('order_key', $this->route('key'))
            ->firstOrFail();

        return $gate->allows('view-shop-order', $this->order);
    }

    public function order(): ShopOrder
    {
        return $this->order;
    }

    public function rules()
    {
        return [];
    }
}
