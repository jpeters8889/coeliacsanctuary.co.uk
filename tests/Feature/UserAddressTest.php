<?php

namespace Tests\Feature;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class UserAddressTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->user->addresses()->insert([
            factory(UserAddress::class)->raw(['user_id' => $this->user->id, 'type' => 'Shipping']),
            factory(UserAddress::class)->raw(['user_id' => $this->user->id, 'type' => 'Billing']),
        ]);

        $this->actingAs($this->user);
    }

    /** @test */
    public function it_doesnt_load_the_page_if_no_user_is_signed_in()
    {
        Auth::logout();
        $this->assertFalse($this->isAuthenticated());

        $this->getJson('/api/member/addresses')->assertStatus(401);
    }

    /** @test */
    public function it_doesnt_load_the_page_if_the_users_email_isnt_verified()
    {
        $this->user->update(['email_verified_at' => null]);

        $this->get('/api/member/addresses')->assertStatus(403);
    }

    /** @test */
    public function it_returns_ok()
    {
        $this->get('/api/member/addresses')->assertOk();
    }

    /** @test */
    public function it_returns_the_users_addresses()
    {
        $response = $this->get('/api/member/addresses')->json();

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }

    /** @test */
    public function it_returns_the_required_data()
    {
        $keys = ['line_1', 'line_2', 'line_3', 'town', 'postcode', 'country', 'type'];

        $response = $this->get('/api/member/addresses')->json();

        foreach($response as $index => $address) {
            foreach ($keys as $key) {
                $this->assertArrayHasKey($key, $address);
                $this->assertEquals($this->user->addresses[$index]->$key, $address[$key]);
            }
        }
    }

    /** @test */
    public function it_doesnt_return_addresses_that_dont_belong_to_the_user()
    {
        $user = factory(User::class)->create();
        factory(UserAddress::class)->create(['line_1' => 'Another Address', 'user_id' => $user->id]);

        $request = $this->get('/api/member/addresses');

        $this->assertCount(2, $request->json());

        $request->assertJsonMissing(['line_1' => 'Another Address']);
    }

    /** @test */
    public function it_can_delete_an_address()
    {
        $this->assertCount(2, $this->user->addresses);

        $this->delete("/api/member/addresses/{$this->user->addresses[0]->id}")->assertOk();

        $this->assertCount(1, $this->user->fresh()->addresses);
    }

    /** @test */
    public function it_only_soft_deletes_addresses()
    {
        $address = $this->user->addresses->first();

        $this->assertCount(2, $this->user->addresses()->withTrashed()->get());
        $this->assertNull($address->deleted_at);

        $this->delete("/api/member/addresses/{$address->id}");

        $this->assertCount(2, $this->user->fresh()->addresses()->withTrashed()->get());
        $this->assertNotNull($address->fresh()->deleted_at);
    }

    /** @test */
    public function it_doesnt_delete_addresses_that_dont_belong_to_the_user()
    {
        $user = factory(User::class)->create();
        $address = factory(UserAddress::class)->create(['line_1' => 'Another Address', 'user_id' => $user->id]);

        $this->assertCount(1, $user->addresses);

        $this->delete("/api/member/addresses/{$address->id}")->assertStatus(403);

        $this->assertCount(1, $user->fresh()->addresses);
    }

    /** @test */
    public function it_errors_when_updating_without_a_name()
    {
        //
    }

    /** @test */
    public function it_errors_when_updating_without_a_line_1()
    {
        //
    }

    /** @test */
    public function it_errors_when_updating_without_a_town()
    {
        //
    }

    /** @test */
    public function it_errors_when_updating_without_a_postcode()
    {
        //
    }

    /** @test */
    public function it_errors_when_updating_without_a_country()
    {
        //
    }

    /** @test */
    public function it_errors_when_updating_a_shipping_address_with_an_invalid_country()
    {
        //
    }

    /** @test */
    public function it_returns_ok_when_updating()
    {
        //
    }

    /** @test */
    public function it_updates_the_address()
    {
        //
    }
}
