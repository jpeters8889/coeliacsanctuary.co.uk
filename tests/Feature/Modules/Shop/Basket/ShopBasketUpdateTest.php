<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Basket;

use Carbon\Carbon;
use Coeliac\Common\Models\Image;
use Tests\TestCase;
use Illuminate\Session\Store;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Models\ShopProductVariant;

class ShopBasketUpdateTest extends TestCase
{
    use WithFaker;

    private Store $session;
    private Basket $basket;
    private ShopProduct $product;
    private ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpFaker();

        $this->session = resolve(Store::class);
        $this->basket = resolve(Basket::class);

        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 500]), 'prices')
            ->create();

        $this->variant = $this->build(ShopProductVariant::class)
            ->in($this->product)
            ->create();
    }

    protected function makeRequest($params = [])
    {
        return $this->put('/api/shop/basket', array_merge([
            'product' => $this->product->id,
            'variant' => $this->variant->id,
            'action' => 'increase',
        ], $params));
    }

    /** @test */
    public function itErrorsWhenAProductIsntSent()
    {
        $this->makeRequest(['product' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAnUnknownProductId()
    {
        $this->makeRequest(['product' => 'foo'])->assertStatus(422);
        $this->makeRequest(['product' => 2])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAProductWithNoLiveVariants()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAnItemWithoutAVariantId()
    {
        $this->makeRequest(['variant' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAnUnknownVariantId()
    {
        $this->makeRequest(['variant' => 'foo'])->assertStatus(422);
        $this->makeRequest(['variant' => 2])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAVariantThatIsntLive()
    {
        $this->variant->update(['live' => false]);

        $this->makeRequest()->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAVariantThatDoesntBelongToTheProduct()
    {
        $variant = $this->build(ShopProductVariant::class)
            ->in($this->build(ShopProduct::class)
                ->has($this->build(ShopProductPrice::class)->state(['price' => 500]), 'prices')
                ->create())
            ->create();

        $this->makeRequest(['variant' => $variant->id])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenNotSendingAnAction()
    {
        $this->makeRequest(['action' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSendingAnUnknownAction()
    {
        $this->makeRequest(['action' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAProductThatIsntInTheBasket()
    {
        $product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 500]), 'prices')
            ->create();

        $variant = $this->build(ShopProductVariant::class)
            ->in($product)
            ->create();

        $this->basket->items()->add($product, $variant);

        $this->makeRequest()
            ->assertStatus(400)
            ->assertJson(['error' => 'Item isn\'t available in your basket']);
    }

    /** @test */
    public function itErrorsWhenTryingToIncreaseQuantityWhenNoneIsAvailable()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->variant->update(['quantity' => 0]);

        $this->makeRequest()
            ->assertStatus(400)
            ->assertJson(['error' => 'Sorry, this product is out of stock']);
    }

    /** @test */
    public function itIncreasesTheQuantity()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $item = ShopOrderItem::query()->first();

        $this->assertEquals(1, $item->quantity);

        $this->makeRequest()->assertStatus(200);

        $this->assertEquals(2, $item->fresh()->quantity);
    }

    /** @test */
    public function itDecreasesTheQuantity()
    {
        $this->basket->items()->add($this->product, $this->variant, 2);

        $item = ShopOrderItem::query()->first();

        $this->assertEquals(2, $item->quantity);

        $this->makeRequest(['action' => 'decrease'])->assertStatus(200);

        $this->assertEquals(1, $item->fresh()->quantity);
    }

    /** @test */
    public function itDeletesAnItemWhenQuantityReachesZero()
    {
        $this->basket->items()->add($this->product, $this->variant);

        $this->assertNotEmpty(ShopOrderItem::query()->get());

        $this->makeRequest(['action' => 'decrease']);

        $this->assertEmpty(ShopOrderItem::query()->get());
    }
}
