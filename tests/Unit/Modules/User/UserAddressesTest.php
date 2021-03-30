<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

use Tests\TestCase;
use Tests\Traits\CreateUser;
use Tests\Traits\Shop\CreateOrder;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAddressesTest extends TestCase
{
    use RefreshDatabase;
    use CreateUser;
    use CreateOrder;

    /** @test */
    public function itHasOrders()
    {
        /** @var User $user */
        $user = $this->createUser();

        /** @var UserAddress $address */
        $address = $user->addresses()->first();

        $this->createOrder([
            'user_id' => $user->id,
            'user_address_id' => $address->id,
        ]);

        $this->createOrder([
            'user_id' => $user->id,
            'user_address_id' => $address->id,
        ]);

        $this->assertEquals(2, $address->orders()->count());
    }

    /** @test */
    public function itHasACustomer()
    {
        /** @var User $user */
        $user = $this->createUser();

        /** @var UserAddress $address */
        $address = $user->addresses()->first();

        $this->assertSame($user->name, $address->user->name);
        $this->assertSame($user->email, $address->user->email);
        $this->assertSame($user->id, $address->user->id);
    }
}
