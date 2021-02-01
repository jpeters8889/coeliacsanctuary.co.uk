<?php

declare(strict_types=1);

namespace Tests\Architect;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Common\Models\Image;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Modules\Member\Models\UserAddress;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use JPeters\Architect\TestHelpers\Traits\LogsInUsers;

class ShopDispatchSlipApiCallTest extends TestCase
{
    use MakesShopOrders;
    use CreateProduct;
    use CreateVariant;
    use HasImages;
    use RefreshDatabase;
    use LogsInUsers;

    protected ShopProduct $product;
    protected ShopProductVariant $variant;
    protected User $user;
    protected ShopOrder $order;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logIn(factory(User::class)->create(['email' => 'jamie@jamie-peters.co.uk']));

        $this->setupPostage();
        $this->setupOrders();

        $this->product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $this->variant = $this->createVariant($this->product, ['weight' => 10]);

        $this->user = factory(User::class)->create([
            'email' => 'foo@bar.com',
            'name' => 'Foo Bar',
        ]);

        $this->createAdminUser();

        factory(UserAddress::class)->create([
            'user_id' => 1,
            'type' => 'Shipping',
        ]);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);

        $this->order = ShopOrder::query()->create([
            'state_id' => ShopOrderState::STATE_PAID,
            'token' => Str::random(8),
            'postage_country_id' => 1,
            'user_id' => 1,
            'user_address_id' => 1,
        ]);

        ShopOrderItem::query()->create([
            'order_id' => 1,
            'product_id' => $this->product->id,
            'product_variant_id' => $this->variant->id,
            'quantity' => 1,
            'product_title' => $this->product->title,
            'product_price' => $this->product->currentPrice,
        ]);

        ShopPayment::query()->create([
            'order_id' => 1,
            'subtotal' => 100,
            'discount' => 0,
            'postage' => 100,
            'total' => 200,
            'payment_type_id' => 1,
        ]);
    }

    // @todo For some reason this test failes due to a libpng warning =/
//    /** @test */
//    public function it_returns_the_pdf()
//    {
//            $this->get('/cs-adm/api/external/coeliac-dispatch-slips/render/1')
//                ->assertStatus(200)
//                ->assertHeader('Content-type', 'application-pdf');
//
//    }

    /** @test */
    public function itMarksTheOrderAsPrinted()
    {
        $this->assertNotEquals(ShopOrderState::STATE_PRINTED, $this->order->state_id);

        $this->put('/cs-adm/api/external/coeliac-dispatch-slips/printed', [
            'id' => 1,
        ])->assertStatus(200);

        $this->assertEquals(ShopOrderState::STATE_PRINTED, $this->order->fresh()->state_id);
    }
}
