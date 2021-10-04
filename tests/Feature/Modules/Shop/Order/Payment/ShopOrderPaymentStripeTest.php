<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Order\Payment;

use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Testing\TestResponse;
use Illuminate\Support\Facades\Event;
use Tests\Mocks\StripePaymentProvider;
use Coeliac\Modules\Shop\Basket\Basket;
use Tests\Traits\Shop\MakeOrderRequest;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Payment\Processor;
use Coeliac\Modules\Shop\Events\CreateOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Payment\Processors\Stripe;

class ShopOrderPaymentStripeTest extends TestCase
{
    use MakeOrderRequest;
    use WithFaker;

    private ShopProduct $product;

    private ShopProduct $product2;

    protected function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->has($this->build(ShopProductVariant::class)->state(['quantity' => 2]), 'variants')
            ->create();

        $this->app->instance(
            Processor::class,
            new Stripe(resolve(Basket::class), new StripePaymentProvider())
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
    public function itReturnsAnInitiatePaymentRequestThatRequiresAction()
    {
        $this->makeRequest()->assertStatus(200)
            ->assertJson([
                'client_secret' => '123abc_secret',
                'payment_id' => '123abc',
                'requires_action' => true,
                'success' => false,
            ]);
    }

    /** @test */
    public function itReturnsAnInitiatePaymentRequestThatIsSuccessful()
    {
        $this->makeRequest([], 'stripe', '123456')->assertStatus(200)
            ->assertJson([
                'client_secret' => '123456_secret',
                'payment_id' => '123456',
                'requires_action' => false,
                'success' => true,
            ]);
    }

    /** @test */
    public function itReturnsAnPaymentProcessingRequestThatRequiresAction()
    {
        $this->makeRequest(['payment_intent_id' => '123abc'], 'stripe', '123abc', 'patch')->assertStatus(200)
            ->assertJson([
                'client_secret' => '123abc_secret',
                'payment_id' => '123abc',
                'requires_action' => true,
                'success' => false,
            ]);
    }

    /** @test */
    public function itCreatesAnOrderCompleteEventWhenTheOrderIsPaidFor()
    {
        Event::fake();

        $this->makeRequest([], 'stripe', '123456');

        Event::assertDispatched(CreateOrder::class);
    }
}
