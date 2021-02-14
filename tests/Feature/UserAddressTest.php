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
}
