<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\TestCase;
use Tests\Traits\CreateUser;
use Coeliac\Common\Models\User;
use Coeliac\Common\Models\UserAddress;
use Tests\Traits\Shop\MakesShopOrders;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;
    use MakesShopOrders;
    use CreateUser;

    /** @test */
    public function it_has_orders()
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
    public function it_has_addresses()
    {
        /** @var User $user */
        $user = $this->createUser();
        factory(UserAddress::class)->create(['user_id' => $user->id]);

        $this->assertEquals(2, $user->addresses()->count());
    }
}
