<?php

namespace Tests\Feature;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UserAddressTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = $this->makeFaker('en_GB');

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

        foreach ($response as $index => $address) {
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

    protected function makeUpdateRequest(array $params = [], ?UserAddress $address = null): TestResponse
    {
        if (!$address) {
            $address = $this->user->addresses[0];
        }

        return $this->post("/api/member/addresses/{$address->id}", array_merge([
            'type' => $address->type,
            'name' => $this->faker->name,
            'line_1' => $this->faker->streetAddress,
            'line_2' => $this->faker->streetSuffix,
            'line_3' => $this->faker->streetName,
            'town' => $this->faker->city,
            'postcode' => $this->faker->postcode,
            'country' => 'United Kingdom',
        ], $params));
    }

    /** @test */
    public function it_errors_without_a_type()
    {
        $this->makeUpdateRequest(['type' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_invalid_type()
    {
        $this->makeUpdateRequest(['type' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_without_a_name()
    {
        $this->makeUpdateRequest(['name' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_without_a_line_1()
    {
        $this->makeUpdateRequest(['line_1' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_without_a_town()
    {
        $this->makeUpdateRequest(['town' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_without_a_postcode()
    {
        $this->makeUpdateRequest(['postcode' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_without_a_country()
    {
        $this->makeUpdateRequest(['country' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_a_shipping_address_with_an_invalid_country()
    {
        $this->makeUpdateRequest([
            'type' => 'Shipping',
            'country' => 'Foo',
        ])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_updating_a_shipping_postcode_to_a_none_uk_postcode_for_a_uk_country()
    {
        $this->makeUpdateRequest([
            'type' => 'Shipping',
            'country' => 'United Kingdom',
            'postcode' => 'foobar',
        ])->assertStatus(422);
    }

    /** @test */
    public function it_returns_ok_when_updating()
    {
        $this->makeUpdateRequest()->assertOk();
    }

    /** @test */
    public function it_updates_the_address()
    {
        $params = [
            'type' => 'Billing',
            'name' => 'New Name',
            'line_1' => 'Line 1',
            'line_2' => 'Line 2',
            'line_3' => 'Line 3',
            'town' => 'Town',
            'postcode' => 'Postcode',
            'country' => 'Country',
        ];

        $address = $this->user->addresses[0];

        $this->makeUpdateRequest($params);

        $address->refresh();

        foreach($params as $key => $value) {
            $this->assertEquals($value, $address->$key);
        }
    }

    /** @test */
    public function it_errors_when_trying_to_update_an_address_for_another_user()
    {
        $user = factory(User::class)->create();
        $address = factory(UserAddress::class)->create(['line_1' => 'Another Address', 'user_id' => $user->id]);

        $this->makeUpdateRequest(['line_1' => 'Changed Address'], $address)->assertStatus(403);

        $address->refresh();

        $this->assertNotEquals('Changed Address', $address->line_1);
    }
}
