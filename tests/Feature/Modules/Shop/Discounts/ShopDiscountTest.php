<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Discounts;

use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopDiscountCodesUsed;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Support\Str;
use Tests\TestCase;

class ShopDiscountTest extends TestCase
{
    private function makeRequest($code = null)
    {
        return $this->post('/api/shop/basket/discount', [
            'code' => $code,
        ]);
    }

    protected function createBasket(): void
    {
        $this->create(ShopDiscountCode::class, [
            'code' => 'foo',
            'name' => 'Foo Discount',
            'min_spend' => 300,
        ]);

        $this->build(ShopProduct::class)
            ->has($this->build(ShopProductVariant::class), 'variants')
            ->has($this->build(ShopProductPrice::class)->state(['price' => 500]), 'prices')
            ->create();

        $token = Str::random(8);

        ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $this->post('/api/shop/basket', [
            'product_id' => 1,
            'variant_id' => 1,
            'quantity' => 1,
        ]);
    }

    /** @test */
    public function itErrorsIfWeDontSendADiscountCode()
    {
        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfWeSendADiscountCodeThatDoesntExist()
    {
        $this->makeRequest('no')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfACodeIsNotYetActive()
    {
        $this->build(ShopDiscountCode::class)
            ->startsTomorrow()
            ->create([
                'code' => 'foo',
            ]);

        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfACodeHasExpired()
    {
        $this->build(ShopDiscountCode::class)
            ->expired()
            ->create([
                'code' => 'foo',
            ]);

        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfACodeHasPassedItsMaximumClaims()
    {
        /** @var ShopDiscountCode $code */
        $code = $this->create(ShopDiscountCode::class, [
            'code' => 'foo',
            'max_claims' => 1,
        ]);

        ShopDiscountCodesUsed::query()->create([
            'discount_id' => $code->id,
            'order_id' => $this->create(ShopOrder::class)->id,
            'discount_amount' => 123,
        ]);

        $this->makeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfWeDontMeetTheMinimumSpend()
    {
        $this->createBasket();

        $this->makeRequest(['code' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itReturnsTheDiscountDataOnASuccessfulRequest()
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
    public function itAddsTheDiscountCodeToTheSession()
    {
        $this->createBasket();

        $this->makeRequest('foo')->assertSessionHas('basket_discount_code', 'foo');
    }
}
