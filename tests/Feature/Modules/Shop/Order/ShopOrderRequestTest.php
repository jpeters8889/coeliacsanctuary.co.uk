<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Order;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\User;
use Coeliac\Common\Models\Image;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Coeliac\Common\Models\UserAddress;
use Tests\Mocks\StripePaymentProvider;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Shop\Basket\Basket;
use Tests\Traits\Shop\MakeOrderRequest;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Payment\Processor;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Payment\Processors\Stripe;

class ShopOrderRequestTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;
    use WithFaker;
    use MakeOrderRequest;
    use CreateProduct;
    use CreateVariant;
    use HasImages;

    /** @var ShopProduct */
    private $product;

    /** @var ShopProduct */
    private $product2;

    protected function setUp(): void
    {
        parent::setUp();

        $this->faker = $this->makeFaker('en_gb');

        $this->setupPostage();
        $this->setupOrders();

        $this->product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $this->product2 = $this->createProduct(null, ['shipping_method_id' => 1]);

        $this->createVariant($this->product, ['live' => 1, 'quantity' => 2]);
        $this->createVariant($this->product2, ['live' => 1, 'quantity' => 0]);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product->id,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        factory(ShopProductPrice::class)->create([
            'product_id' => $this->product2->id,
            'price' => 100,
            'start_at' => Carbon::now()->subHour()->toDateTimeString(),
        ]);

        $this->product->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);
        $this->product2->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SHOP_PRODUCT);
    }

    protected function mockPaymentProcessor()
    {
        $this->app->instance(Processor::class, new Stripe(resolve(Basket::class), new StripePaymentProvider()));
    }

    protected function makeRequest($params = [], $provider = 'stripe', $token = '123abc')
    {
        return $this->post('/api/shop/order', $this->makeOrderRequest($params, $provider, $token));
    }

    /** @test */
    public function itFailsWithoutAPaymentMethod()
    {
        $this->makeRequest([], null)->assertStatus(422);
    }

    /** @test */
    public function itFailsWithAnInvalidPaymentType()
    {
        $this->makeRequest([], 'foo')->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAUser()
    {
        $this->makeRequest(['user' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsIfUserIsntAArray()
    {
        $this->makeRequest(['user' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAUserName()
    {
        $this->makeRequest(['user.name' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAnUserEmail()
    {
        $this->makeRequest(['user.email' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAValidUserEmail()
    {
        $this->makeRequest(['user.email' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAConfirmationEmail()
    {
        $this->makeRequest(['user.emailConfirmation' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAValidEmailConfirmation()
    {
        $this->makeRequest(['user.emailConfirmation' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itFailsWhenTheConfirmationEmailDoesntMatch()
    {
        $this->makeRequest(['user.emailConfirmation' => 'foo@bar.com'])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAShippingAddress()
    {
        $this->makeRequest(['shipping' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWhenTheShippingAddressIsntAnArray()
    {
        $this->makeRequest(['shipping' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutAPostcode()
    {
        $this->makeRequest(['shipping.postcode' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithAnInvalidUkPostcodeWhenCountryIsSetToUk()
    {
        $token = Str::random(8);

        ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $this->makeRequest(['shipping.postcode' => 'foobar'])->assertStatus(422);
    }

    /** @test */
    public function itAllowsAnyPostcodeWhenTheCountryIsNotUk()
    {
        $token = Str::random(8);

        ShopOrder::query()->create([
            'token' => $token,
            'postage_country_id' => 2,
        ]);

        $this->withSession(['basket_token' => $token]);

        $request = $this->makeRequest(['shipping.postcode' => 'foobar']);

        $this->assertNotEquals(422, $request->getStatusCode());
    }

    /** @test */
    public function itFailsWithoutAnAddressLine1()
    {
        $this->makeRequest(['shipping.address1' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutACity()
    {
        $this->makeRequest(['shipping.town' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutABillingAddress()
    {
        $this->makeRequest(['billing' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWhenTheBillingAddressIsntAnArray()
    {
        $this->makeRequest(['billing' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutABillingName()
    {
        $this->makeRequest(['billing.name' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutABillingAddress1()
    {
        $this->makeRequest(['billing.address1' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutABillingCity()
    {
        $this->makeRequest(['billing.town' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutABillingPostcode()
    {
        $this->makeRequest(['billing.postcode' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsWithoutABillingCountry()
    {
        $this->makeRequest(['billing.country' => null])->assertStatus(422);
    }

    /** @test */
    public function itFailsIfThereIsNoBasket()
    {
        $this->makeRequest()->assertStatus(400)->assertJson(['error' => 'no basket']);
    }

    /** @test */
    public function itFailsIfThereAreNoItemsInTheBasket()
    {
        $token = Str::random(8);

        ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $this->makeRequest()->assertStatus(400)->assertJson(['error' => 'no items']);
    }

    /** @test */
    public function itCreatesACustomerIfOneDoesntAlreadyExist()
    {
        $this->mockPaymentProcessor();

        $token = Str::random(8);

        ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $request = $this->post('/api/shop/basket', [
            'product_id' => $this->product->id,
            'variant_id' => $this->product->variants()->first()->id,
            'quantity' => 1,
        ]);

        $this->makeRequest([
            'user.email' => 'me@you.com',
            'user.emailConfirmation' => 'me@you.com',
            'user.phone' => '123456',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'me@you.com',
            'phone' => '123456',
        ]);
    }

    /** @test */
    public function itUpdatesTheUserIdField()
    {
        $this->mockPaymentProcessor();

        $token = Str::random(8);

        /** @var ShopOrder $order */
        $order = ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $this->post('/api/shop/basket', [
            'product_id' => $this->product->id,
            'variant_id' => $this->product->variants()->first()->id,
            'quantity' => 1,
        ]);

        $this->makeRequest();

        $this->assertNotNull($order->fresh()->user_id);
    }

    /** @test */
    public function itMatchesToAnExistingUser()
    {
        $this->mockPaymentProcessor();

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

        User::query()->insert([
            'email' => 'me@you.com',
            'name' => $this->faker->name,
        ]);

        $this->makeRequest(['user.email' => 'me@you.com']);

        $this->assertEquals(1, User::query()->count());
    }

    /** @test */
    public function itUpdatesTheUserAddressIdField()
    {
        $this->mockPaymentProcessor();

        $token = Str::random(8);

        /** @var ShopOrder $order */
        $order = ShopOrder::query()->create([
            'token' => $token,
        ]);

        $this->withSession(['basket_token' => $token]);

        $this->post('/api/shop/basket', [
            'product_id' => $this->product->id,
            'variant_id' => $this->product->variants()->first()->id,
            'quantity' => 1,
        ]);

        $this->makeRequest();

        $this->assertNotNull($order->fresh()->user_address_id);
    }

    /** @test */
    public function itCreatesAShippingAddressIfOneDoesntExist()
    {
        $this->mockPaymentProcessor();

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

        $this->makeRequest([
            'user.name' => 'Name',
            'shipping.address1' => 'Address 1',
            'shipping.address2' => 'Address 2',
            'shipping.address3' => 'Address 3',
            'shipping.town' => 'Town',
            'shipping.postcode' => $postcode = $this->faker->postcode,
        ]);

        $this->assertDatabaseHas('user_addresses', [
            'type' => 'Shipping',
            'name' => 'Name',
            'line_1' => 'Address 1',
            'line_2' => 'Address 2',
            'line_3' => 'Address 3',
            'town' => 'Town',
            'postcode' => $postcode,
        ]);
    }

    /** @test */
    public function itMatchesToAnExistingShippingAddress()
    {
        $this->mockPaymentProcessor();

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

        /* @var User $customer */
        User::query()->create([
            'email' => 'me@you.com',
            'name' => 'Name',
        ])->addresses()->create([
            'type' => 'Shipping',
            'name' => 'Name',
            'line_1' => 'Address 1',
            'line_2' => 'Address 2',
            'line_3' => 'Address 3',
            'town' => 'Town',
            'postcode' => 'Postcode',
            'country' => 1,
        ]);

        $this->makeRequest([
            'user.email' => 'me@you.com',
            'user.name' => 'Name',
            'shipping.address1' => 'Address 1',
            'shipping.address2' => 'Address 2',
            'shipping.address3' => 'Address 3',
            'shipping.town' => 'Town',
            'shipping.postcode' => 'Postcode',
        ]);

        $this->assertEquals(1, UserAddress::query()->where('type', 'Shipping')->count());
    }

    /** @test */
    public function itCreatesABillingAddressIfOneDoesntExist()
    {
        $this->mockPaymentProcessor();

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

        $this->makeRequest([
            'billing.name' => 'Name',
            'billing.address1' => 'Address 1',
            'billing.address2' => 'Address 2',
            'billing.address3' => 'Address 3',
            'billing.town' => 'Town',
            'billing.postcode' => 'Postcode',
            'billing.country' => 'Country',
        ]);

        $this->assertDatabaseHas('user_addresses', [
            'type' => 'Billing',
            'name' => 'Name',
            'line_1' => 'Address 1',
            'line_2' => 'Address 2',
            'line_3' => 'Address 3',
            'town' => 'Town',
            'postcode' => 'Postcode',
            'country' => 'Country',
        ]);
    }

    /** @test */
    public function itMatchesToAnExistingBillingAddress()
    {
        $this->mockPaymentProcessor();

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

        /* @var User $customer */
        User::query()->create([
            'email' => 'me@you.com',
            'name' => 'Name',
        ])->addresses()->create([
            'type' => 'Billing',
            'name' => 'Name',
            'line_1' => 'Address 1',
            'line_2' => 'Address 2',
            'line_3' => 'Address 3',
            'town' => 'Town',
            'postcode' => 'Postcode',
            'country' => 'Country;',
        ]);

        $this->makeRequest([
            'user.email' => 'me@you.com',
            'user.name' => 'Name',
            'billing.name' => 'Name',
            'billing.address1' => 'Address 1',
            'billing.address2' => 'Address 2',
            'billing.address3' => 'Address 3',
            'billing.town' => 'Town',
            'billing.postcode' => 'Postcode',
            'billing.country' => 'Country',
        ]);

        $this->assertEquals(1, UserAddress::query()->where('type', 'Billing')->count());
    }
}
