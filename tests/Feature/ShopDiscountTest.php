<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\Shop\CreateOrder;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopDiscountCodesUsed;

class ShopDiscountTest extends TestCase
{
    use CreateOrder;
    use RefreshDatabase;
    use CreateVariant;
    use CreateProduct;

    private function makeRequest($code = null)
    {
        return $this->post('/api/shop/basket/discount', [
            'code' => $code,
        ]);
    }

    private function createCode($params = []): ShopDiscountCode
    {
        return factory(ShopDiscountCode::class)->create($params);
    }

    protected function createBasket(): void
    {
        $this->createCode([
            'code' => 'foo',
            'name' => 'Foo Discount',
            'min_spend' => 600,
            'start_at' => Carbon::now()->subHour(),
        ]);

        $product = $this->createProduct();
        $variant = $this->createVariant($product, ['live' => true]);
        factory(ShopProductPrice::class)->create([
            'product_id' => $product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $token = Str::random(8);

        ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $this->post('/api/shop/basket', [
            'product_id' => $product->id,
            'variant_id' => $variant->id,
            'quantity' => 1,
        ]);
    }

    /** @test */
    public function it_errors_if_we_dont_send_a_discount_code()
    {
        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_we_send_a_discount_code_that_doesnt_exist()
    {
        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_a_code_is_not_yet_active()
    {
        $this->createCode(['code' => 'foo', 'start_at' => Carbon::now()->addDay()]);

        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_a_code_has_expired()
    {
        $this->createCode(['code' => 'foo', 'end_at' => Carbon::now()->subDay()]);

        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_a_code_has_passed_its_maximum_claims()
    {
        /** @var ShopOrder $order */
        $order = $this->createOrder();

        /** @var ShopDiscountCode $code */
        $code = $this->createCode([
            'code' => 'foo',
            'start_at' => Carbon::now()->subDay(),
            'max_claims' => 1,
        ]);

        ShopDiscountCodesUsed::query()->create([
            'discount_id' => $code->id,
            'order_id' => $order->id,
            'discount_amount' => 123,
        ]);

        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_there_is_no_basket()
    {
        $this->createCode(['code' => 'foo']);

        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function it_errors_if_we_dont_meet_the_minimum_spend()
    {
        $this->createBasket();

        $this->makeRequest(['code' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_returns_the_discount_data_on_a_successful_request()
    {
        $this->createBasket();

        $this->makeRequest('foo')
            ->assertStatus(200)
            ->assertJson([
            'name' => 'Foo Discount',
            'code' => 'foo',
        ]);
    }

    /** @test */
    public function it_adds_the_discount_code_to_the_session()
    {
        $this->createBasket();

        $this->makeRequest('foo')->assertSessionHas('basket_discount_code', 'foo');
    }
}
