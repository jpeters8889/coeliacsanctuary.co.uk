<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use GuzzleHttp\Client;
use Tests\Mocks\PostcodeLookupMock;
use Coeliac\Modules\Shop\PostcodeLookup\Service;
use Coeliac\Modules\Shop\PostcodeLookup\GetAddress\Parser;

class ShopPostcodeLookupTest extends TestCase
{
    private Service $postcodeService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postcodeService = new PostcodeLookupMock(new Client(), new Parser());

        $this->app->singleton(Service::class, function () {
            return $this->postcodeService;
        });
    }

    /** @test */
    public function it_errors_without_a_postcode()
    {
        $this->makeRequest(null)->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_non_alpha_num_characters()
    {
        $this->makeRequest('£$%^')->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_the_postcode_is_too_short()
    {
        $this->makeRequest('cw1')->assertStatus(422);
    }

    /** @test */
    public function it_is_successful_with_valid_requests()
    {
        $this->instance(Service::class, $this->postcodeService);

        $this->makeRequest('cw15ew')->assertStatus(200);
    }

    /** @test */
    public function it_returns_an_array()
    {
        $this->instance(Service::class, $this->postcodeService);

        $request = $this->makeRequest('cw15ew');

        $this->assertIsArray($request->json()['data']);
    }

    public function fieldsInAddress()
    {
        return [
            ['address_1'],
            ['address_2'],
            ['address_3'],
            ['town'],
            ['county'],
            ['postcode'],
            ['friendly'],
            ['house_number'],
        ];
    }

    /**
     * @test
     * @dataProvider fieldsInAddress
     */
    public function it_returns_an_address_1_field($field)
    {
        $this->instance(Service::class, $this->postcodeService);

        $request = $this->makeRequest('cw15ew');

        $firstResult = $request->json()['data'][0];

        $this->assertArrayHasKey($field, $firstResult);
    }

    /** @test */
    public function it_returns_a_correctly_formatted_normal_address()
    {
        $this->instance(Service::class, $this->postcodeService);

        $this->makeRequest('cw15ew')
            ->assertJsonFragment([
                'address_1' => '18 Gresty Terrace',
                'address_2' => null,
                'address_3' => null,
                'town' => 'Crewe',
                'county' => 'Cheshire',
                'postcode' => 'CW15EW',
                'friendly' => '18 Gresty Terrace, Crewe, Cheshire, CW15EW',
                'house_number' => 18,
            ]);
    }

    /** @test */
    public function it_returns_a_correctly_formatted_longer_address()
    {
        $this->instance(Service::class, $this->postcodeService);

        $this->makeRequest('s653lh')
            ->assertJsonFragment([
                'address_1' => '4 Fretwell Road',
                'address_2' => 'East Herringthorpe',
                'address_3' => null,
                'town' => 'Rotherham',
                'county' => 'South Yorkshire',
                'postcode' => 'S653LH',
                'friendly' => '4 Fretwell Road, East Herringthorpe, Rotherham, South Yorkshire, S653LH',
                'house_number' => 4,
            ]);
    }

    /** @test */
    public function it_returns_a_correctly_formatted_none_number_address()
    {
        $this->instance(Service::class, $this->postcodeService);

        $this->makeRequest('st42rw')
            ->assertJsonFragment([
                'address_1' => 'Winton Property Ltd',
                'address_2' => 'Winton House',
                'address_3' => 'Stoke Road',
                'town' => 'Stoke-on-Trent',
                'county' => 'Staffordshire',
                'postcode' => 'ST42RW',
                'friendly' => 'Winton Property Ltd, Winton House, Stoke Road, Stoke-on-Trent, Staffordshire, ST42RW',
                'house_number' => 0,
            ]);
    }

    /** @test */
    public function it_returns_a_correctly_formatted_very_long_address()
    {
        $this->instance(Service::class, $this->postcodeService);

        $this->makeRequest('a1bcd')
            ->assertJsonFragment([
                'address_1' => '123 Fake Street',
                'address_2' => 'Nowhereville',
                'address_3' => 'Here, There',
                'town' => 'Everywhere',
                'county' => 'Cheshire',
                'postcode' => 'A1BCD',
                'friendly' => '123 Fake Street, Nowhereville, Here, There, Everywhere, Cheshire, A1BCD',
                'house_number' => 123,
            ]);
    }

    /** @test */
    public function it_correctly_orders_addresses()
    {
        $this->instance(Service::class, $this->postcodeService);

        $request = $this->makeRequest('s653lh');

        [$firstResult, $secondResult, $thirdResult] = $request->json()['data'];

        $this->assertArrayHas('address_1', '2 Fretwell Road', $firstResult);
        $this->assertArrayHas('address_1', '4 Fretwell Road', $secondResult);
        $this->assertArrayHas('address_1', '20 Fretwell Road', $thirdResult);
    }

    /** @test */
    public function it_performs_an_actual_real_lookup_to_the_api()
    {
        $request = $this->makeRequest('cw15ew')->assertStatus(200);

        $this->assertIsArray($request->json()['data']);
    }

    private function makeRequest($postcode)
    {
        return $this->post('/api/shop/lookup', ['postcode' => $postcode]);
    }
}
