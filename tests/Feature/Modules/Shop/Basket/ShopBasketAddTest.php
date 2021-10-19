<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Basket;

use Carbon\Carbon;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;
use Illuminate\Session\Store;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopBasketAddTest extends TestCase
{
    private Store $session;
    private Basket $basket;
    private ShopProduct $product;
    private ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->session = resolve(Store::class);
        $this->basket = resolve(Basket::class);

        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 500]), 'prices')
            ->create();

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->create();
    }

    protected function makeRequest($params = []): TestResponse
    {
        return $this->post('/api/shop/basket', array_merge([
            'product_id' => $this->product->id,
            'variant_id' => $this->variant->id,
            'quantity' => 1,
        ], $params));
    }

    /** @test */
    public function itErrorsWhenTryingToAddAnItemWithoutAProductId()
    {
        $this->makeRequest(['product_id' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAnUnknownProductId()
    {
        $this->makeRequest(['product_id' => 'foo'])->assertStatus(422);
        $this->makeRequest(['product_id' => 2])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAProductWithNoLiveVariants()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAnItemWithoutAVariantId()
    {
        $this->makeRequest(['variant_id' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAnUnknownVariantId()
    {
        $this->makeRequest(['variant_id' => 'foo'])->assertStatus(422);
        $this->makeRequest(['variant_id' => 2])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAVariantThatIsntLive()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAVariantThatDoesntBelongToTheProduct()
    {
        $variant = $this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
                ->has($this->build(ShopProductPrice::class), 'prices')
                ->create())
            ->create();

        $this->makeRequest(['variant_id' => $variant->id])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAVariantThatIsntInStock()
    {
        $this->variant->update(['quantity' => 0]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAnItemWithoutAQuantity()
    {
        $this->makeRequest(['quantity' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAnItemWithAnInvalidQuantity()
    {
        $this->makeRequest(['quantity' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToAddAnItemWithANegativeQuantiy()
    {
        $this->makeRequest(['quantity' => 0])->assertStatus(422);
        $this->makeRequest(['quantity' => -1])->assertStatus(422);
    }

    /** @test */
    public function itReturnsSuccessWhenSendingValidData()
    {
        $this->makeRequest()
            ->assertStatus(200)
            ->assertJsonStructure(['data' => ['quantity', 'product_title', 'product_price', 'subtotal']]);
    }

    /** @test */
    public function itDoesntHaveAUserIdByDefault()
    {
        $this->makeRequest();

        $this->assertNull(ShopOrder::query()->first()->user_id);
    }

    /** @test */
    public function itAddsTheItemToTheBasket()
    {
        $this->makeRequest();

        $this->assertCount(1, ShopOrderItem::query()->get());
        $this->assertTrue($this->product->is(ShopOrderItem::query()->first()->product));
        $this->assertTrue($this->variant->is(ShopOrderItem::query()->first()->variant));
    }

    /** @test */
    public function itLinksTheBasketToALoggedInUser()
    {
        $this->actingAs($user = $this->create(User::class));

        $this->makeRequest();

        $basket = ShopOrder::query()->first();

        $this->assertNotNull($basket->user_id);
        $this->assertEquals($user->id, $basket->user_id);
    }
}
