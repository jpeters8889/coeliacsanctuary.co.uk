<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Requests\ApplyDiscountRequest;
use Illuminate\Session\Store;

class BasketDiscountController extends BaseController
{
    public function create(ApplyDiscountRequest $request, Store $sessionStore): array
    {
        /** @var ShopDiscountCode $discountCode */
        $discountCode = $request->getDiscountCode();

        $sessionStore->put('basket_discount_code', $discountCode->code);

        return [
            'code' => $discountCode->code,
            'name' => $discountCode->name,
        ];
    }
}
