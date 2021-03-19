<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;

class WhereToEatQuickSearchTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        WhereToEatCounty::query()->insert([
            ['county' => 'South Yorkshire', 'slug' => 'south-yorkshire', 'legacy' => 'foo', 'country_id' => 1],
            ['county' => 'North Yorkshire', 'slug' => 'north-yorkshire', 'legacy' => 'foo', 'country_id' => 1],
            ['county' => 'West Yorkshire', 'slug' => 'west-yorkshire', 'legacy' => 'foo', 'country_id' => 1],
            ['county' => 'Cheshire', 'slug' => 'cheshire', 'legacy' => 'foo', 'country_id' => 1],
            ['county' => 'Staffordshire', 'slug' => 'staffordshire', 'legacy' => 'foo', 'country_id' => 1],
        ]);

        WhereToEatTown::query()->insert([
            ['town' => 'Crewe', 'slug' => 'crewe', 'legacy' => 'foo', 'county_id' => 1],
            ['town' => 'Rotherham', 'slug' => 'rotherham', 'legacy' => 'foo', 'county_id' => 1],
            ['town' => 'Rothtown', 'slug' => 'rothtown', 'legacy' => 'foo', 'county_id' => 1],
            ['town' => 'Stoke', 'slug' => 'stoke', 'legacy' => 'foo', 'county_id' => 1],
            ['town' => 'Stockport', 'slug' => 'stockport', 'legacy' => 'foo', 'county_id' => 1],
        ]);
    }

    public function makeRequest($term): TestResponse
    {
        return $this->post('/api/wheretoeat/quick-search', [
            'term' => $term,
        ]);
    }

    /** @test */
    public function itErrorsIfWeDontPassASearchTerm()
    {
        $this->makeRequest('')->assertStatus(422);
    }

    /** @test */
    public function itReturnsAValidResultForATown()
    {
        $this->makeRequest('rotherham')
            ->assertStatus(200)
            ->assertJsonStructure([['label', 'url']])
            ->assertSee('Rotherham')
            ->assertSee('/rotherham');
    }

    /** @test */
    public function itReturnsMultipleTownResults()
    {
        $this->makeRequest('roth')
            ->assertSee('Rotherham')
            ->assertSee('Rothtown');
    }

    /** @test */
    public function itReturnsACounty()
    {
        $this->makeRequest('cheshire')
            ->assertStatus(200)
            ->assertJsonStructure([['label', 'url']])
            ->assertSee('Cheshire')
            ->assertSee('/cheshire');
    }

    /** @test */
    public function itReturnsMultipleCounties()
    {
        $this->makeRequest('yorkshire')
            ->assertSee('South Yorkshire')
            ->assertSee('North Yorkshire')
            ->assertSee('West Yorkshire');
    }

    /** @test */
    public function itReturnsAMixtureOfTownsAndCounties()
    {
        $this->makeRequest('st')
            ->assertSee('Stoke')
            ->assertSee('Stockport')
            ->assertSee('Staffordshire');
    }
}
