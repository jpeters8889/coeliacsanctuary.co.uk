<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Order\Payment;

use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Events\CreateOrder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Coeliac\Modules\Shop\Payment\Processor;
use Coeliac\Modules\Shop\Payment\Processors\PayPal;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Tests\Mocks\PaypalPaymentProvider as PaypalPaymentProviderMock;
use Tests\TestCase;
use Tests\Traits\Shop\MakeOrderRequest;

class ShopOrderPaymentPayPalTest extends TestCase
{
    use MakeOrderRequest;
    use WithFaker;

    private ShopProduct $product;

    protected function setUp(): void
    {
        parent::setUp();

        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->has($this->build(ShopProductVariant::class)->state(['quantity' => 2]), 'variants')
            ->create();

        $this->app->instance(
            Processor::class,
            new PayPal(resolve(Basket::class), new PaypalPaymentProviderMock())
        );

        $token = Str::random(8);

        ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $this->post('/api/shop/basket', [
            'product_id' => $this->product->id,
            'variant_id' => $this->product->variants()->first()->id,
            'quantity' => 1,
        ]);
    }

    protected function makeRequest($params = [], $provider = 'stripe', $token = '123abc', $method = 'post'): TestResponse
    {
        return $this->$method('/api/shop/order', $this->makeOrderRequest($params, $provider, $token));
    }

    /** @test */
    public function itCreatesAnOrderCompleteEventWhenTheOrderIsPaidFor()
    {
        Event::fake();

        $this->makeRequest([], 'paypal', '123456', 'patch');

        Event::assertDispatched(CreateOrder::class);
    }
}
