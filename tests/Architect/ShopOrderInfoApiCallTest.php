<?php

declare(strict_types=1);

namespace Tests\Architect;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\User;
use Coeliac\Common\Models\Image;
use Illuminate\Testing\TestResponse;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Common\Models\UserAddress;
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

class ShopOrderInfoApiCallTest extends TestCase
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
    protected TestResponse $request;

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

        $this->request = $this->get('/cs-adm/api/external/order-info/get/'.$this->order->id);
    }

    /** @test */
    public function it_returns_a_succesful_response()
    {
        $this->request->assertStatus(200);
    }

    /**
     * @test
     * @dataProvider coreArrayKeys
     */
    public function it_has_all_required_top_level_keys($key)
    {
        $this->assertArrayHasKey($key, $this->request->json());
    }

    public function coreArrayKeys()
    {
        return [
            ['id'], ['state_id'], ['postage_country_id'], ['token'], ['order_key'], ['user_id'], ['user_address_id'],
            ['shipped_at'], ['newsletter_signup'], ['items'], ['user'], ['address'], ['payment'], ['discount_code'],
        ];
    }

    /** @test */
    public function it_returns_the_items_as_an_aray()
    {
        $this->assertIsArray($this->request->json('items'));
    }

    /**
     * @test
     * @dataProvider itemKeys
     */
    public function it_returns_the_required_items_keys($key)
    {
        $this->assertArrayHasKey($key, $this->request->json('items.0'));
    }

    public function itemKeys()
    {
        return [['quantity'], ['product_title'], ['product_price'], ['subtotal']];
    }

    /**
     * @test
     * @dataProvider userKeys
     */
    public function it_returns_the_required_user_keys($key)
    {
        $this->assertArrayHasKey($key, $this->request->json('user'));
    }

    public function userKeys()
    {
        return [['id'], ['name'], ['email'], ['phone']];
    }

    /**
     * @test
     * @dataProvider addressKeys
     */
    public function it_returns_the_required_address_keys($key)
    {
        $this->assertArrayHasKey($key, $this->request->json('address'));
    }

    public function addressKeys()
    {
        return [['name'], ['line_1'], ['line_2'], ['line_3'], ['town'], ['postcode'], ['country']];
    }

    /**
     * @test
     * @dataProvider paymentKeys
     */
    public function it_returns_the_required_payment_keys($key)
    {
        $this->assertArrayHasKey($key, $this->request->json('payment'));
    }

    public function paymentKeys()
    {
        return [['subtotal'], ['discount'], ['postage'], ['total'], ['type']];
    }

    /** @test */
    public function it_returns_the_payment_type()
    {
        $this->assertArrayHasKey('type', $this->request->json('payment.type'));
    }
}
