<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Tests\TestCase;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\UserLevel;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Member\Models\ScrapbookItem;

class UserTest extends TestCase
{
    /** @test */
    public function itHasOrders()
    {
        /** @var User $user */
        $user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->asShipping(), 'addresses')
            ->create();

        $this->build(ShopOrder::class)
            ->to($user)
            ->count(2)
            ->create();

        $this->assertEquals(2, $user->orders()->count());
    }

    /** @test */
    public function itHasAddresses()
    {
        /** @var User $user */
        $user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->count(2), 'addresses')
            ->create();

        $this->assertEquals(2, $user->addresses()->count());
    }

    /** @test */
    public function itShowsMembersArentApprovedByDefault()
    {
        /** @var User $user */
        $user = $this->create(User::class);

        $this->assertFalse($user->isMember());
    }

    /** @test */
    public function itKnowsWhetherAUserIsAMember()
    {
        /** @var User $user */
        $user = $this->build(User::class)
            ->asMember()
            ->create();

        $this->assertTrue($user->isMember());
    }

    /** @test */
    public function itKnowsWhetherTheUserIsAnAdmin()
    {
        $user = $this->build(User::class)
            ->asAdmin()
            ->create();

        $this->assertTrue($user->isMember());
        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function normalAndShopMembersAreNotAdmins()
    {
        [$shopUser, $normalUser] = $this->build(User::class)
            ->count(2)
            ->state(new Sequence(
                ['user_level_id' => UserLevel::SHOP],
                ['user_level_id' => UserLevel::MEMBER],
            ))
            ->create();

        $this->assertFalse($shopUser->isAdmin());
        $this->assertFalse($normalUser->isAdmin());
    }

    /** @test */
    public function itCanHaveScrapbooks()
    {
        $user = $this->create(User::class);

        $this->assertCount(0, $user->scrapbooks);

        $this->build(Scrapbook::class)->in($user)->create();

        $this->assertCount(1, $user->fresh()->scrapbooks);

        $this->build(Scrapbook::class)->in($user)->create();

        $this->assertCount(2, $user->fresh()->scrapbooks);
    }

    /** @test */
    public function itHasScapbookItems()
    {
        $user = $this->build(User::class)
            ->has($this->build(Scrapbook::class), 'scrapbooks')
            ->create();

        $this->assertEmpty($user->fresh()->scrapbookItems);

        $item = $this->build(ScrapbookItem::class)
            ->in($user->scrapbooks[0])
            ->create();

        $this->assertCount(1, $user->scrapbookItems);

        $this->assertTrue($user->scrapbookItems[0]->is($item));
    }
}
