<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

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
}
