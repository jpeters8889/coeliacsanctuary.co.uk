<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\UserLevel;
use Tests\TestCase;
use Tests\Traits\CreateUser;
use Tests\Traits\Shop\MakesShopOrders;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
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
    public function it_shows_members_arent_approved_by_default()
    {
        /** @var User $user */
        $user = $this->createUser();

        $this->assertFalse($user->isMember());
    }

    /** @test */
    public function it_knows_whether_a_user_is_a_member()
    {
        /** @var User $user */
        $user = $this->createUser(['user_level_id' => UserLevel::MEMBER]);

        $this->assertTrue($user->isMember());
    }

    /** @test */
    public function it_knows_whether_the_user_is_an_admin()
    {
        /** @var User $user */
        $user = $this->createUser(['user_level_id' => UserLevel::ADMIN]);

        $this->assertTrue($user->isMember());
        $this->assertTrue($user->isAdmin());
    }

    /** @test */
    public function normal_and_shop_members_are_not_admins()
    {
        $shopUser = $this->createUser();
        $normalUser = $this->createUser(['user_level_id' => UserLevel::MEMBER]);

        $this->assertFalse($shopUser->isAdmin());
        $this->assertFalse($normalUser->isAdmin());
    }

    /** @test */
    public function it_can_have_scrapbooks()
    {
        $user = $this->createUser();

        $this->assertCount(0, $user->scrapbooks);

        factory(Scrapbook::class)->create(['user_id' => $user->id]);

        $this->assertCount(1, $user->fresh()->scrapbooks);

        factory(Scrapbook::class)->create(['user_id' => $user->id]);

        $this->assertCount(2, $user->fresh()->scrapbooks);
    }
}
