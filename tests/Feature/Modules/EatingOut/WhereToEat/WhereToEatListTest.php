<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\NationwideBranch;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class WhereToEatListTest extends TestCase
{
    /** @var WhereToEat */
    private $wheretoeat;

    public function setUp(): void
    {
        parent::setUp();

        Event::fake();

        $this->wheretoeat = $this->build(WhereToEat::class)
            ->has($this->build(WhereToEatFeature::class), 'features')
            ->create();
    }

    /** @test */
    public function itLoadsTheMainWheretoeatDetailEndpoint()
    {
        $this->get('/api/wheretoeat')
            ->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    'current_page',
                    'data',
                    'first_page_url',
                    'from',
                    'last_page',
                    'last_page_url',
                    'next_page_url',
                    'path',
                    'per_page',
                    'prev_page_url',
                    'to',
                    'total',
                ],
            ]);
    }

    /** @test */
    public function itHasAPlaceDetails()
    {
        $data = $this->get('/api/wheretoeat')->json('data.data.0');

        $this->assertEquals($this->wheretoeat->id, $data['id']);
        $this->assertEquals($this->wheretoeat->name, $data['name']);
        $this->assertEquals($this->wheretoeat->town_id, $data['town_id']);
        $this->assertEquals($this->wheretoeat->county_id, $data['county_id']);
        $this->assertEquals($this->wheretoeat->country_id, $data['country_id']);
        $this->assertEquals($this->wheretoeat->info, $data['info']);
        $this->assertEquals($this->wheretoeat->address, $data['address']);
        $this->assertEquals($this->wheretoeat->phone, $data['phone']);
        $this->assertEquals($this->wheretoeat->website, $data['website']);
        $this->assertEquals($this->wheretoeat->lat, $data['lat']);
        $this->assertEquals($this->wheretoeat->lng, $data['lng']);
        $this->assertEquals($this->wheretoeat->type_id, $data['type_id']);
        $this->assertEquals($this->wheretoeat->venue_type_id, $data['venue_type_id']);
        $this->assertEquals($this->wheretoeat->cuisine_id, $data['cuisine_id']);
        $this->assertEquals($this->wheretoeat->live, $data['live']);
        $this->assertEquals($this->wheretoeat->average_rating, $data['average_rating']);
        $this->assertArrayHasKey('country', $data);
        $this->assertArrayHasKey('county', $data);
        $this->assertArrayHasKey('town', $data);
        $this->assertArrayHasKey('type', $data);
        $this->assertArrayHasKey('venue_type', $data);
        $this->assertArrayHasKey('cuisine', $data);
        $this->assertArrayHasKey('features', $data);
        $this->assertArrayHasKey('restaurants', $data);
        $this->assertArrayHasKey('reviews', $data);
        $this->assertArrayHasKey('user_reviews', $data);

        $this->assertEquals([
            'id' => $this->wheretoeat->country->id,
            'country' => $this->wheretoeat->country->country,
        ], $data['country']);

        $this->assertEquals([
            'id' => $this->wheretoeat->county->id,
            'county' => $this->wheretoeat->county->county,
            'slug' => $this->wheretoeat->county->slug,
        ], $data['county']);

        $this->assertEquals([
            'id' => $this->wheretoeat->town->id,
            'town' => $this->wheretoeat->town->town,
            'slug' => $this->wheretoeat->town->slug,
            'county_id' => $this->wheretoeat->county_id,
        ], $data['town']);

        $this->assertEquals([
            'id' => $this->wheretoeat->type->id,
            'type' => $this->wheretoeat->type->type,
            'name' => $this->wheretoeat->type->name,
        ], $data['type']);

        $this->assertEquals([
            'id' => $this->wheretoeat->venueType->id,
            'venue_type' => $this->wheretoeat->venueType->venue_type,
        ], $data['venue_type']);

        $this->assertEquals([
            'id' => $this->wheretoeat->cuisine->id,
            'cuisine' => $this->wheretoeat->cuisine->cuisine,
        ], $data['cuisine']);

        $this->assertIsArray($data['features']);

        $this->assertEquals([
            'id' => $this->wheretoeat->features()->first()->id,
            'feature' => $this->wheretoeat->features()->first()->feature,
            'icon' => $this->wheretoeat->features()->first()->icon,
            'image' => $this->wheretoeat->features()->first()->image,
        ], $data['features'][0]);
    }

    /** @test */
    public function itHasReviewsOnPlaceDetails()
    {
        $review = $this->build(Review::class)->at($this->wheretoeat)->create();

        $data = $this->get('/api/wheretoeat')->json('data.data.0');

        $this->assertIsArray($data['reviews']);

        $this->assertEquals([
            'id' => (int)$review->id,
            'wheretoeat_id' => (string)$this->wheretoeat->id,
            'title' => $review->title,
            'slug' => $review->slug,
            'created_at' => $review->created_at->toJson(),
            'link' => $review->link,
            'main_image' => null,
            'architect_title' => $review->architect_title,
            'eatery' => $review->eatery->toArray(),
        ], $data['reviews'][0]);
    }

    /** @test */
    public function itMixesInANationwideBranchIfItHasABranchInTheGivenTown(): void
    {
        $this->create(WhereToEatCounty::class, ['county' => 'Nationwide']);
        $this->create(WhereToEatTown::class, ['town' => 'Nationwide']);

        /** @var WhereToEat $nationwidePlace */
        $nationwidePlace = $this->build(WhereToEat::class)
            ->has($this->build(WhereToEatFeature::class), 'features')
            ->create([
                'name' => 'Nationwide Eatery',
                'county_id' => 2,
                'town_id' => 2,
            ]);

        $nationwideBranch = $this->build(NationwideBranch::class)
            ->create(['wheretoeat_id' => $nationwidePlace->id, 'town_id' => 1]);

        $eateries = $this->get('/api/wheretoeat?filter[county]=1&filter[town]=1')
            ->json('data.data');

        $this->assertCount(2, $eateries);

        $placeNames = Arr::map($eateries, fn (array $eatery) => $eatery['name']);

        $this->assertContains('Nationwide Eatery', $placeNames);
    }
}
