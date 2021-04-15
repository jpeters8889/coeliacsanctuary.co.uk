<?php

declare(strict_types=1);

namespace Tests\Architect;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Illuminate\Support\Facades\Event;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Events\ShipOrder;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use JPeters\Architect\TestHelpers\Traits\LogsInUsers;

class ShopShipApiCallTest extends TestCase
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

    /** @test */
    public function itEmitsAnOrderShippedEvent()
    {
        Event::fake([ShipOrder::class]);

        $request = $this->post('/cs-adm/api/external/order/ship', ['id' => 1]);

        Event::assertDispatched(ShipOrder::class);
    }
}
