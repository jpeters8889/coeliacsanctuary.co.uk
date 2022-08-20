<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserAddress;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class UserAddressTest extends TestCase
{
    use WithFaker;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->faker = $this->makeFaker('en_GB');

        $this->user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->asShipping(), 'addresses')
            ->has($this->build(UserAddress::class)->asBilling(), 'addresses')
            ->create();

        $this->actingAs($this->user);
    }

    /** @test */
    public function itDoesntLoadThePageIfNoUserIsSignedIn()
    {
        Auth::logout();

        $this->assertFalse($this->isAuthenticated());

        $this->getJson('/api/member/addresses')->assertStatus(401);
    }

    /** @test */
    public function itDoesntLoadThePageIfTheUsersEmailIsntVerified()
    {
        $this->user->update(['email_verified_at' => null]);

        $this->get('/api/member/addresses')->assertStatus(403);
    }

    /** @test */
    public function itReturnsOk()
    {
        $this->get('/api/member/addresses')->assertOk();
    }

    /** @test */
    public function itReturnsTheUsersAddresses()
    {
        $response = $this->get('/api/member/addresses')->json();

        $this->assertIsArray($response);
        $this->assertCount(2, $response);
    }

    /** @test */
    public function itReturnsTheRequiredData()
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
    public function itDoesntReturnAddressesThatDontBelongToTheUser()
    {
        $this->build(User::class)
            ->has($this->build(UserAddress::class)->state(['line_1' => 'Another Address']), 'addresses')
            ->create();

        $request = $this->get('/api/member/addresses');

        $this->assertCount(2, $request->json());

        $request->assertJsonMissing(['line_1' => 'Another Address']);
    }

    /** @test */
    public function itCanDeleteAnAddress()
    {
        $this->assertCount(2, $this->user->addresses);

        $this->delete("/api/member/addresses/{$this->user->addresses[0]->id}")->assertOk();

        $this->assertCount(1, $this->user->fresh()->addresses);
    }

    /** @test */
    public function itOnlySoftDeletesAddresses()
    {
        $address = $this->user->addresses->first();

        $this->assertCount(2, $this->user->addresses()->withTrashed()->get());
        $this->assertNull($address->deleted_at);

        $this->delete("/api/member/addresses/{$address->id}");

        $this->assertCount(2, $this->user->fresh()->addresses()->withTrashed()->get());
        $this->assertNotNull($address->fresh()->deleted_at);
    }

    /** @test */
    public function itDoesntDeleteAddressesThatDontBelongToTheUser()
    {
        $user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->state(['line_1' => 'Another Address']), 'addresses')
            ->create();

        $this->assertCount(1, $user->addresses);

        $this->delete("/api/member/addresses/{$user->addresses[0]->id}")->assertStatus(403);

        $this->assertCount(1, $user->fresh()->addresses);
    }

    protected function makeUpdateRequest(array $params = [], ?UserAddress $address = null): TestResponse
    {
        if (! $address) {
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
    public function itErrorsWithoutAType()
    {
        $this->makeUpdateRequest(['type' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithAnInvalidType()
    {
        $this->makeUpdateRequest(['type' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingWithoutAName()
    {
        $this->makeUpdateRequest(['name' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingWithoutALine1()
    {
        $this->makeUpdateRequest(['line_1' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingWithoutATown()
    {
        $this->makeUpdateRequest(['town' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingWithoutAPostcode()
    {
        $this->makeUpdateRequest(['postcode' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingWithoutACountry()
    {
        $this->makeUpdateRequest(['country' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingAShippingAddressWithAnInvalidCountry()
    {
        $this->makeUpdateRequest([
            'type' => 'Shipping',
            'country' => 'Foo',
        ])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenUpdatingAShippingPostcodeToANoneUkPostcodeForAUkCountry()
    {
        $this->makeUpdateRequest([
            'type' => 'Shipping',
            'country' => 'United Kingdom',
            'postcode' => 'foobar',
        ])->assertStatus(422);
    }

    /** @test */
    public function itReturnsOkWhenUpdating()
    {
        $this->makeUpdateRequest()->assertOk();
    }

    /** @test */
    public function itUpdatesTheAddress()
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

        foreach ($params as $key => $value) {
            $this->assertEquals($value, $address->$key);
        }
    }

    /** @test */
    public function itErrorsWhenTryingToUpdateAnAddressForAnotherUser()
    {
        $user = $this->build(User::class)
            ->has($this->build(UserAddress::class)->state(['line_1' => 'Another Address']), 'addresses')
            ->create();

        $address = $user->addresses[0];

        $this->makeUpdateRequest(['line_1' => 'Changed Address'], $address)->assertStatus(403);

        $address->refresh();

        $this->assertNotEquals('Changed Address', $address->line_1);
    }
}
