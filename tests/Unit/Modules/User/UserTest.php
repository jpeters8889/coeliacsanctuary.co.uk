<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

use Tests\TestCase;
use Tests\Traits\CreateUser;
use Coeliac\Modules\Blog\Models\Blog;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Member\Models\ScrapbookItem;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;
    use CreateUser;

    /** @test */
    public function itHasOrders()
    {
        /** @var User $user */
        $user = $this->createUser();

        $this->createOrder([
            'user_id' => $user->id,
            'user_address_id' => $user->addresses()->first()->id,
        ]);

        $this->createOrder([
            'user_id' => $user->id,
            'user_address_id' => $user->addresses()->first()->id,
        ]);

        $this->assertEquals(2, $user->orders()->count());
    }

    /** @test */
    public function itHasAddresses()
    {
        /** @var User $user */
        $user = $this->createUser();
        factory(UserAddress::class)->create(['user_id' => $user->id]);

        $this->assertEquals(2, $user->addresses()->count());
    }

    /** @test */
    public function itShowsMembersArentApprovedByDefault()
    {
        /** @var User $user */
        $user = $this->createUser();

        $this->assertFalse($user->isMember());
    }

    /** @test */
    public function itKnowsWhetherAUserIsAMember()
    {
        /** @var User $user */
        $user = $this->createUser(['user_level_id' => UserLevel::MEMBER]);

        $this->assertTrue($user->isMember());
    }

    /** @test */
    public function itKnowsWhetherTheUserIsAnAdmin()
    {
        /** @var User $user */
        $user = $this->createUser(['user_level_id' => UserLevel::ADMIN]);

        $this->assertTrue($user->isMember());
        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function normalAndShopMembersAreNotAdmins()
    {
        $shopUser = $this->createUser();
        $normalUser = $this->createUser(['user_level_id' => UserLevel::MEMBER]);

        $this->assertFalse($shopUser->isAdmin());
        $this->assertFalse($normalUser->isAdmin());
    }

    /** @test */
    public function itCanHaveScrapbooks()
    {
        $user = $this->createUser();

        $this->assertCount(0, $user->scrapbooks);

        factory(Scrapbook::class)->create(['user_id' => $user->id]);

        $this->assertCount(1, $user->fresh()->scrapbooks);

        factory(Scrapbook::class)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->fresh()->scrapbooks);
    }

    /** @test */
    public function itHasScapbookItems()
    {
        $user = $this->createUser();

        $this->assertEmpty($user->fresh()->scrapbookItems);

        factory(Scrapbook::class)->create(['user_id' => $user->id]);
        $item = ScrapbookItem::query()->create([
            'scrapbook_id' => 1,
            'item_type' => Blog::class,
            'item_id' => 1,
        ]);

        $this->assertNotEmpty($user->fresh()->scrapbookItems);
        $this->assertCount(1, $user->scrapbookItems);

        $this->assertTrue($user->scrapbookItems[0]->is($item));
    }
}
