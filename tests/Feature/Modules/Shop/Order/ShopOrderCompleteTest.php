<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Shop\Order;

use Carbon\Carbon;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Shop\Models\ShopProductVariant;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Illuminate\Support\Str;
use Coeliac\Modules\Member\Models\User;
use Tests\Traits\Shop\MakeOrderRequest;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Shop\Models\ShopPayment;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopProductPrice;
use Coeliac\Modules\Shop\Payment\Providers\StripePaymentProvider;
use Tests\Mocks\StripePaymentProvider as StripePaymentProviderMock;

class ShopOrderCompleteTest extends TestCase
{
    use MakeOrderRequest;
    use WithFaker;

    /** @var ShopProduct */
    private $product;

    /** @var ShopProduct */
    private $product2;

    /** @test */
    public function itRedirectsToTheMainShopPageIfThereIsntAOpenBasket()
    {
        $this->get('/shop/basket/done')->assertRedirect('/shop');
    }

    private function setupOrder($params = [])
    {
        $this->product = $this->build(ShopProduct::class)
            ->has($this->build(ShopProductPrice::class)->state(['price' => 100]), 'prices')
            ->has($this->build(ShopProductVariant::class)->state(['quantity' => 2]), 'variants')
            ->create();

        $this->app->instance(StripePaymentProvider::class, new StripePaymentProviderMock());

        $token = Str::random(8);

        ShopOrder::query()->create(array_merge([
            'token' => $token,
            'user_id' => $this->create(User::class)->id,
        ], $params));

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
    public function itShowsTheFormToBecomeAMemberWhenOrderingAsAGuest()
    {
        $this->setupOrder();

        $user = User::query()->where('email', '!=', 'contact@coeliacsanctuary.co.uk')->first();

        $this->get('/shop/basket/done')
            ->assertSee('<member-register-order-complete-cta name="'.$user->name.'"', false);
    }

    /** @test */
    public function itDoesntShowTheFormToRegisterIfAlreadyLoggedIn()
    {
        $this->setupOrder();

        $this->actingAs(User::query()->where('email', '!=', 'contact@coeliacsanctuary.co.uk')->first());

        $this->get('/shop/basket/done')->assertDontSee('order-complete-create-account');
    }

    /** @test */
    public function itDoesntShowTheRegisterFormIfTheUserAlreadyExistsButIsntLoggedIn()
    {
        $this->setupOrder();

        User::query()
            ->where('email', '!=', 'contact@coeliacsanctuary.co.uk')
            ->first()
            ->update(['user_level_id' => UserLevel::MEMBER]);

        $this->get('/shop/basket/done')->assertDontSee('order-complete-create-account');
    }

    /** @test */
    public function itListsTwoRecentBlogs()
    {
        $this->setupOrder();

        $this->build(Blog::class)
            ->count(3)
            ->state(new Sequence(
                ['title' => 'First Blog', 'created_at' => Carbon::now()->subDays(3)],
                ['title' => 'Second Blog', 'created_at' => Carbon::now()->subDays(2)],
                ['title' => 'Third Blog', 'created_at' => Carbon::now()->subDay()],
            ))
            ->create();

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

        $this->build(Recipe::class)
            ->count(4)
            ->state(new Sequence(
                ['title' => 'First Recipe', 'created_at' => Carbon::now()->subDays(3)],
                ['title' => 'Second Recipe', 'created_at' => Carbon::now()->subDays(2)],
                ['title' => 'Third Recipe', 'created_at' => Carbon::now()->subDay()],
                ['title' => 'Fourth Recipe', 'created_at' => Carbon::now()],
            ))
            ->create();

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

        $this->build(Review::class)
            ->count(3)
            ->state(new Sequence(
                ['title' => 'First Review', 'created_at' => Carbon::now()->subDays(2)],
                ['title' => 'Second Review', 'created_at' => Carbon::now()->subDay()],
                ['title' => 'Third Review', 'created_at' => Carbon::now()],
            ))
            ->create();

        $this->get('/shop/basket/done')
            ->assertSee('Latest Reviews', false)
            ->assertSee('Third Review', false)
            ->assertSee('Second Review', false)
            ->assertDontSee('First Review');
    }
}
