<?php

namespace Tests\Feature;

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
    public function it_errors_if_we_dont_pass_a_search_term()
    {
        $this->makeRequest('')->assertStatus(422);
    }

    /** @test */
    public function it_returns_a_valid_result_for_a_town()
    {
        $this->makeRequest('rotherham')
            ->assertStatus(200)
            ->assertJsonStructure([['label', 'url']])
            ->assertSee('Rotherham')
            ->assertSee('/rotherham');
    }

    /** @test */
    public function it_returns_multiple_town_results()
    {
        $this->makeRequest('roth')
            ->assertSee('Rotherham')
            ->assertSee('Rothtown');
    }

    /** @test */
    public function it_returns_a_county()
    {
        $this->makeRequest('cheshire')
            ->assertStatus(200)
            ->assertJsonStructure([['label', 'url']])
            ->assertSee('Cheshire')
            ->assertSee('/cheshire');
    }

    /** @test */
    public function it_returns_multiple_counties()
    {
        $this->makeRequest('yorkshire')
            ->assertSee('South Yorkshire')
            ->assertSee('North Yorkshire')
            ->assertSee('West Yorkshire');
    }

    /** @test */
    public function it_returns_a_mixture_of_towns_and_counties()
    {
        $this->makeRequest('st')
            ->assertSee('Stoke')
            ->assertSee('Stockport')
            ->assertSee('Staffordshire');
    }
}
