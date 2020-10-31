<?php

declare(strict_types=1);

namespace Tests\Architect;

use Tests\TestCase;
use Coeliac\Common\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JPeters\Architect\TestHelpers\Traits\LogsInUsers;

class AddressLookupApiCallTest extends TestCase
{
    use RefreshDatabase;
    use LogsInUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->logIn(factory(User::class)->create(['email' => 'jamie@jamie-peters.co.uk']));
    }

    /** @test */
    public function it_looksup_an_address()
    {
        $this->post('/cs-adm/api/external/coeliac-address-lookup/lookup', [
           'address' => 'Kings Cross Station, London',
        ])->assertStatus(200);
    }
}
