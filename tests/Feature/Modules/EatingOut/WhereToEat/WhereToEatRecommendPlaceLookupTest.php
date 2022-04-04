<?php

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class WhereToEatRecommendPlaceLookupTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->create(WhereToEat::class, ['name' => 'Test Eatery']);
    }

    protected function makeRequest(null|string $term): TestResponse
    {
        return $this->post('/api/wheretoeat/recommend-a-place/lookup', [
            'term' => $term,
        ]);
    }

    /** @test */
    public function itErrorsWithoutASearchTerm(): void
    {
        $this->makeRequest(null)->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithASearchTermLessThanThreeCharacters(): void
    {
        $this->makeRequest('hi')->assertStatus(422);
    }

    /** @test */
    public function itReturnsOkWithAValidRequest(): void
    {
        $this->makeRequest('foo')->assertOk();
    }

    /** @test */
    public function itDoesntReturnAnyResultsIfNothingMatches(): void
    {
        $this->makeRequest('foo')
            ->assertJsonStructure(['results'])
            ->assertJsonCount(0, 'results');
    }

    /** @test */
    public function itReturnsPartialMatches(): void
    {
        $this->makeRequest('test')->assertJsonCount(1, 'results');

        $this->makeRequest('eat')->assertJsonCount(1, 'results');

        $this->makeRequest('eatery')->assertJsonCount(1, 'results');
    }

    /** @test */
    public function itReturnsMultipleResults(): void
    {
        $this->create(WhereToEat::class, ['name' => 'Another Eatery']);

        $this->makeRequest('eatery')->assertJsonCount(2, 'results');
    }

    /** @test */
    public function itDoesntReturnPlacesThatArentLive(): void
    {
        $this->build(WhereToEat::class)
            ->notLive()
            ->create(['name' => 'Not Live']);

        $this->makeRequest('live')->assertJsonCount(0, 'results');
    }

    /** @test */
    public function itFormatsTheResults(): void
    {
        $this->makeRequest('eatery')->assertJsonStructure([
            'results' => [['name', 'location']],
        ]);
    }
}
