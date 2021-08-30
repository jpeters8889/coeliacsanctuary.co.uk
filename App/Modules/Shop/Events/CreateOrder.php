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

    public function __construct(
        private ShopOrder $model,
        private int $postage,
        private string $paymentMethod,
        private array|object $paymentResponse,
        private ?ShopDiscountCode $discountCode = null
    ) {
    }

    public function discountCode(): ?ShopDiscountCode
    {
        return $this->discountCode;
    }

    public function model(): ShopOrder
    {
        return $this->model;
    }

    public function postage(): int
    {
        return $this->postage;
    }

    public function paymentMethod(): string
    {
        return $this->paymentMethod;
    }

    public function paymentResponse(): string
    {
        return (string) json_encode($this->paymentResponse);
    }
}
