<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Order;

use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Str;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Common\Models\Image;
use Tests\Traits\CreatesRecipes;
use Tests\Traits\CreatesReviews;
use Tests\Traits\CreatesWhereToEat;
use Tests\Traits\Shop\CreateProduct;
use Tests\Traits\Shop\CreateVariant;
use Tests\Traits\Shop\MakesShopOrders;
use Tests\Traits\Shop\MakeOrderRequest;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Shop\Payment\Providers\StripePaymentProvider;
use Tests\Mocks\StripePaymentProvider as StripePaymentProviderMock;

class ShopOrderCompleteTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;
    use MakeOrderRequest;
    use CreateProduct;
    use CreateVariant;
    use WithFaker;
    use CreatesBlogs;
    use CreatesRecipes;
    use CreatesReviews;
    use CreatesWhereToEat;
    use HasImages;

    /** @var ShopProduct */
    private $product;

    /** @var ShopProduct */
    private $product2;

    /** @test */
    public function itRedirectsToTheMainShopPageIfThereIsntAOpenBasket()
    {
        $this->get('/shop/basket/done')->assertRedirect('/shop');
    }

    private function setupOrder()
    {
        $this->setupPostage();
        $this->setupOrders();

        $this->product = $this->createProduct(null, ['shipping_method_id' => 1]);
        $this->product2 = $this->createProduct(null, ['shipping_method_id' => 1]);

        $this->createVariant($this->product, ['live' => 1, 'quantity' => 2]);
        $this->createVariant($this->product2, ['live' => 1, 'quantity' => 0]);

        $this->createAdminUser();

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

        $this->app->instance(StripePaymentProvider::class, new StripePaymentProviderMock());

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

        ShopOrder::query()->first()->update(['state_id' => ShopOrderState::STATE_PAID]);

        ShopPayment::query()->create([
            'order_id' => 1,
            'subtotal' => 1,
            'discount' => 0,
            'postage' => 1,
            'total' => 1,
            'payment_type_id' => 1,
        ]);
    }

    /** @test */
    public function itListsTwoRecentBlogs()
    {
        $this->setupOrder();

        $this->createBlog([
            'title' => 'First Blog',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        $this->createBlog([
            'title' => 'Second Blog',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $this->createBlog([
            'title' => 'Third Blog',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->get('/shop/basket/done')
            ->assertSee('Latest Blogs', false)
            ->assertSee('Second Blog', false)
            ->assertSee('Third Blog', false)
            ->assertDontSee('First Blog');
    }

    /** @test */
    public function itListsThreeRecentRecipes()
    {
        $this->setupOrder();

        $this->createRecipe([
            'title' => 'First Recipe',
            'created_at' => Carbon::now()->subDays(3),
        ]);

        $this->createRecipe([
            'title' => 'Second Recipe',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $this->createRecipe([
            'title' => 'Third Recipe',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->createRecipe([
            'title' => 'Fourth Recipe',
            'created_at' => Carbon::now(),
        ]);

        $this->get('/shop/basket/done')
            ->assertSee('Latest Recipes', false)
            ->assertSee('Fourth Recipe', false)
            ->assertSee('Third Recipe', false)
            ->assertSee('Second Recipe', false)
            ->assertDontSee('First Recipe');
    }

    /** @test */
    public function itListsTwoRecentReviews()
    {
        $this->setupOrder();

        $this->createReview([
            'title' => 'First Review',
            'created_at' => Carbon::now()->subDays(2),
        ]);

        $this->createReview([
            'title' => 'Second Review',
            'created_at' => Carbon::now()->subDays(1),
        ]);

        $this->createReview([
            'title' => 'Third Review',
            'created_at' => Carbon::now(),
        ]);

        $this->get('/shop/basket/done')
            ->assertSee('Latest Reviews', false)
            ->assertSee('Third Review', false)
            ->assertSee('Second Review', false)
            ->assertDontSee('First Review');
    }
}
