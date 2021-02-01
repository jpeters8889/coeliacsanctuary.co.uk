<?php

declare(strict_types=1);

namespace Tests\Architect;

use Carbon\Carbon;
use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;
use Tests\Traits\Shop\CreateOrder;
use Illuminate\Testing\TestResponse;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use JPeters\Architect\TestHelpers\Traits\LogsInUsers;

class ShopItemsApiCallTest extends TestCase
{
    use CreateOrder;
    use CreateProduct;
    use CreateVariant;
    use RefreshDatabase;
    use LogsInUsers;

    private ShopOrder $order;
    private ShopProduct $product;
    private ShopProductVariant $variant;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logIn(factory(User::class)->create(['email' => 'jamie@jamie-peters.co.uk']));

        $this->order = $this->createOrder();

        $this->product = $this->createProduct();

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 500,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->variant = $this->createVariant($this->product);
    }

    /** @test */
    public function itReturnsASuccesfulResponse()
    {
        $this->makeRequest()->assertStatus(200);
    }

    /** @test */
    public function itReturnsAnEmptyArrayWhenTheresNoItems()
    {
        $this->makeRequest()->assertJson([]);
    }

    /** @test */
    public function itReturnsAnItemsDetails()
    {
        $this->addItem();

        $request = $this->makeRequest();

        $request->assertStatus(200);

        $content = $request->json();

        $this->assertIsArray($content);

        $keys = ['quantity', 'product_title', 'product_price', 'subtotal'];

        foreach ($keys as $key) {
            $this->assertArrayHasKey($key, $content[0]);
        }
    }

    protected function makeRequest(): TestResponse
    {
        return $this->get('/cs-adm/api/external/coeliac-shop-order-items/items/'.$this->order->id);
    }

    public function addItem($quantity = 1, ?ShopProduct $product = null, ?ShopProductVariant $variant = null)
    {
        if (!$product) {
            $product = $this->product;
        }

        if (!$variant) {
            $variant = $this->variant;
        }

        factory(ShopOrderItem::class)->create([
            'order_id' => $this->order->id,
            'quantity' => $quantity,
            'product_id' => $product->id,
            'product_variant_id' => $variant->id,
            'product_title' => $product->title,
            'product_price' => $product->currentPrice,
        ]);
    }
}
