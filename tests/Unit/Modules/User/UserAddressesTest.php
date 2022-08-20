<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\User;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Tests\TestCase;

class UserAddressesTest extends TestCase
{
    /** @test */
    public function itHasOrders()
    {
        /** @var User $user */
        $user = $this->build(User::class)
            ->has($this->build(UserAddress::class), 'addresses')
            ->create();

        /** @var UserAddress $address */
        $address = $user->addresses()->first();

        $this->build(ShopOrder::class)
            ->to($user, $address)
            ->count(2)
            ->create();

        $this->assertEquals(2, $address->orders()->count());
    }

    /** @test */
    public function itHasACustomer()
    {
        /** @var User $user */
        $user = $this->build(User::class)
            ->has($this->build(UserAddress::class), 'addresses')
            ->create();

        /** @var UserAddress $address */
        $address = $user->addresses()->first();

        $this->assertSame($user->name, $address->user->name);
        $this->assertSame($user->email, $address->user->email);
        $this->assertSame($user->id, $address->user->id);
    }
}
