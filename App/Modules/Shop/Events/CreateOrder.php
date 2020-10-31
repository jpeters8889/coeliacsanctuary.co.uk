<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Events;

use Illuminate\Queue\SerializesModels;
use Coeliac\Modules\Shop\Basket\Postage;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;

class CreateOrder
{
    use SerializesModels;

    private ShopOrder $model;
    private $postage;
    private $paymentResponse;
    private $paymentMethod;
    private ?ShopDiscountCode $discountCode = null;

    public function __construct(ShopOrder $model, $postage, $paymentMethod, $paymentResponse, ?ShopDiscountCode $discountCode = null)
    {
        $this->model = $model;
        $this->postage = $postage;
        $this->paymentMethod = $paymentMethod;
        $this->paymentResponse = $paymentResponse;
        $this->discountCode = $discountCode;
    }

    public function discountCode()
    {
        return $this->discountCode;
    }

    public function model()
    {
        return $this->model;
    }

    public function postage()
    {
        return $this->postage;
    }

    public function paymentMethod()
    {
        return $this->paymentMethod;
    }

    public function paymentResponse()
    {
        return json_encode($this->paymentResponse);
    }
}
