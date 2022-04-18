<?php

namespace Tests\Acceptance;

use Coeliac\Common\Models\Popup;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatPlaceReport;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRecommendation;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class CoeliacSanctuaryOnTheGoTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function itCanGetPlacesToEat(): void
    {
        $this->create(WhereToEat::class, ['name' => 'My Eatery']);

        $this->get('/api/wheretoeat')
            ->assertOk()
            ->assertJsonFragment(['name' => 'My Eatery']);
    }

    /** @test */
    public function itCanGetPlacesViaSearchTerm(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $this->setUpScout();

        $this->create(WhereToEat::class, [
            'name' => 'My Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
        ]);

        $params = ['term' => 'London', 'range' => 15, 'lat' => 0, 'lng' => 0];

        $this->get('/api/wheretoeat?search=' . json_encode($params))
            ->assertOk()
            ->assertJsonFragment(['name' => 'My Eatery']);
    }

    /** @test */
    public function itCanGetPlacesViaLatLng(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $this->setUpScout();

        $this->create(WhereToEat::class, [
            'name' => 'My Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
        ]);

        $params = ['term' => '', 'range' => 15, 'lat' => 51, 'lng' => 0.1];

        $this->get('/api/wheretoeat?search=' . json_encode($params))
            ->assertOk()
            ->assertJsonFragment(['name' => 'My Eatery']);
    }

    /** @test */
    public function itCanGetPlacesWithFilters(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $this->setUpScout();

        $venueType = $this->create(WhereToEatVenueType::class, ['venue_type' => 'Special Place']);

        $this->create(WhereToEat::class, [
            'name' => 'My Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
            'venue_type_id' => $venueType->id,
        ]);

        $this->create(WhereToEat::class, [
            'name' => 'My Other Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
        ]);

        $params = ['term' => '', 'range' => 15, 'lat' => 51, 'lng' => 0.1];

        $this->get('/api/wheretoeat?search=' . json_encode($params) . '&filter[venueType]=' . $venueType->id)
            ->assertOk()
            ->assertJsonFragment(['name' => 'My Eatery'])
            ->assertJsonMissing(['name' => 'My Other Eatery']);
    }

    /** @test */
    public function itCanGetPaginatedPlaces(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $this->setUpScout();

        $this->build(WhereToEat::class, )->count(20)->create();

        $this->get('/api/wheretoeat')->assertOk();
        $this->get('/api/wheretoeat?page=2')->assertOk();
    }

    /** @test */
    public function itGetsPlacesAndReturnsTheRequiredData(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $this->setUpScout();

        $eatery = $this->create(WhereToEat::class, [
            'name' => 'My Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
        ]);

        $params = ['term' => '', 'range' => 15, 'lat' => 51, 'lng' => 0.1];

        $this->build(WhereToEatReview::class)->on($eatery)->approved()->create();

        $this->get('/api/wheretoeat?search=' . json_encode($params))
            ->assertJsonStructure([
                'data' => [
                    'current_page',
                    'from',
                    'last_page',
                    'per_page',
                    'to',
                    'total',
                    'data' => [
                        [
                            'address',
                            'average_rating',
                            'created_at',
                            'county' => [
                                'county',
                                'id',
                            ],
                            'country' => [
                                'country',
                                'id',
                            ],
                            'cuisine' => [
                                'cuisine',
                                'id',
                            ],
                            'features' => [],
                            'icon',
                            'id',
                            'info',
                            'lat',
                            'lng',
                            'name',
                            'phone',
                            'ratings' => [],
                            'restaurants' => [],
                            'reviews' => [],
                            'town' => [
                                'id',
                                'town',
                            ],
                            'type' => [
                                'id',
                                'name',
                                'type',
                            ],
                            'venue_type' => [
                                'id',
                                'venue_type',
                            ],
                            'website',
                        ],
                    ],
                    'appends' => [
                        'latlng' => ['lat', 'lng'],
                    ],
                ],
            ]);
    }

    /** @test */
    public function itCanGetPlacesToEatForTheMap(): void
    {
        $this->create(WhereToEat::class, [
            'name' => 'My Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
        ]);

        $this->get('/api/wheretoeat/browse?lat=51&lng=-0.1&range=15')
            ->assertOk()
            ->assertJsonFragment(['name' => 'My Eatery']);
    }

    /** @test */
    public function itCanGetPlacesWithFiltersForTheMap(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $this->setUpScout();

        $venueType = $this->create(WhereToEatVenueType::class, ['venue_type' => 'Special Place']);

        $this->create(WhereToEat::class, [
            'name' => 'My Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
            'venue_type_id' => $venueType->id,
        ]);

        $this->create(WhereToEat::class, [
            'name' => 'My Other Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
        ]);

        $this->get('/api/wheretoeat/browse?lat=51&lng=-0.1&range=15&filter[venueType]=' . $venueType->id)
            ->assertOk()
            ->assertJsonFragment(['name' => 'My Eatery'])
            ->assertJsonMissing(['name' => 'My Other Eatery']);
    }

    /** @test */
    public function itReturnsTheRequiredDataForTheMap(): void
    {
        $this->create(WhereToEat::class, [
            'name' => 'My Eatery',
            'lat' => 51.5, // London
            'lng' => -0.1, // London
            'county_id' => $this->create(WhereToEatCounty::class)->id,
        ]);

        $this->get('/api/wheretoeat/browse?lat=51&lng=-0.1&range=15')
            ->assertJsonStructure([
                'data' => [[
                    'id',
                    'lat',
                    'lng',
                    'name',
                    'distance',
                    'full_name',
                    'full_location',
                    'type_description',
                ]],
            ]);
    }

    /** @test */
    public function itCanGetAPlaceDetails(): void
    {
        $eatery = $this->create(WhereToEat::class);

        $this->get('/api/wheretoeat/' . $eatery->id)
            ->assertOk()
            ->assertJsonStructure([
                'address',
                'average_rating',
                'created_at',
                'county' => [
                    'county',
                    'id',
                ],
                'country' => [
                    'country',
                    'id',
                ],
                'cuisine' => [
                    'cuisine',
                    'id',
                ],
                'features' => [],
                'icon',
                'id',
                'info',
                'lat',
                'lng',
                'name',
                'phone',
                'ratings' => [],
                'restaurants' => [],
                'reviews' => [],
                'town' => [
                    'id',
                    'town',
                ],
                'type' => [
                    'id',
                    'name',
                    'type',
                ],
                'venue_type' => [
                    'id',
                    'venue_type',
                ],
                'website',
            ]);
    }

    /** @test */
    public function itCanGetNationwidePlaces(): void
    {
        $eatery = $this->create(WhereToEat::class);

        $this->get('/api/wheretoeat?filter[county]=1')
            ->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'data' => [
                        [
                            'address',
                            'average_rating',
                            'created_at',
                            'county' => [
                                'county',
                                'id',
                            ],
                            'country' => [
                                'country',
                                'id',
                            ],
                            'cuisine' => [
                                'cuisine',
                                'id',
                            ],
                            'features' => [],
                            'icon',
                            'id',
                            'info',
                            'lat',
                            'lng',
                            'name',
                            'phone',
                            'ratings' => [],
                            'restaurants' => [],
                            'reviews' => [],
                            'town' => [
                                'id',
                                'town',
                            ],
                            'type' => [
                                'id',
                                'name',
                                'type',
                            ],
                            'venue_type' => [
                                'id',
                                'venue_type',
                            ],
                            'website',
                        ]
                    ],
                ],
            ]);
    }

    /** @test */
    public function itCanGetTheLatestBlogs(): void
    {
        $this->create(Blog::class, ['title' => 'My Blog']);

        $this->get('/api/blogs')->assertOk()->assertJsonFragment(['title' => 'My Blog']);
    }

    /** @test */
    public function itCanGetTheLatestRecipes(): void
    {
        $this->create(Recipe::class, ['title' => 'My Recipe']);

        $this->get('/api/recipes')->assertOk()->assertJsonFragment(['title' => 'My Recipe']);
    }

    /** @test */
    public function itItCanGetTheLatestReviews(): void
    {
        $this->create(Review::class, ['title' => 'My Review']);

        $this->get('/api/reviews')->assertOk()->assertJsonFragment(['title' => 'My Review']);
    }

    /** @test */
    public function itCanGetTheWhereToEatSummary(): void
    {
        $this->get('/api/wheretoeat/summary')
            ->assertOk()
            ->assertJsonStructure(['total', 'eateries', 'attractions', 'hotels', 'reviews']);
    }

    /** @test */
    public function itCanGetTheLatestPlaceRatings(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $eatery = $this->create(WhereToEat::class, ['name' => 'My Eatery']);

        $this->build(WhereToEatReview::class)
            ->on($eatery)
            ->count(5)
            ->create();

        $this->get('/api/wheretoeat/ratings/latest')->assertOk();
    }

    /** @test */
    public function itCanGetTheLatestPlacesAdded(): void
    {
        $this->build(WhereToEat::class)
            ->count(5)
            ->create();

        $this->get('/api/wheretoeat/latest')->assertOk();
    }

    /** @test */
    public function itCanGetTheShopCta(): void
    {
        $this->create(Popup::class);

        $this->get('/api/popup')->assertOk();
    }

    /** @test */
    public function itCanGetTheListOfVenueTypes(): void
    {
        $this->get('/api/wheretoeat/venueTypes')->assertOk();
    }

    /** @test */
    public function itCanSearchForALatLng(): void
    {
        $this->post('/api/wheretoeat/lat-lng', ['term' => 'London'])->assertOk();
    }

    /** @test */
    public function itCanSubmitAnEateryRating(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $eatery = $this->create(WhereToEat::class, ['name' => 'My Eatery']);

        $this->assertCount(0, WhereToEatReview::all());

        $this->post("/api/wheretoeat/{$eatery->id}/reviews", ['rating' => 5, 'method' => 'app'])
            ->assertOk();

        $this->assertCount(1, WhereToEatReview::all());
    }

    /** @test */
    public function itCanSubmitAnEateryReview(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        $eatery = $this->create(WhereToEat::class, ['name' => 'My Eatery']);

        $this->assertCount(0, WhereToEatReview::all());

        $this->post("/api/wheretoeat/{$eatery->id}/reviews", [
            'rating' => 5,
            'name' => 'foo',
            'email' => 'foo@bar.com',
            'comment' => 'foo bar baz',
            'method' => 'app',
        ])->assertOk();

        $this->assertCount(1, WhereToEatReview::all());
    }

    /** @test */
    public function itCanRecommendAPlace(): void
    {
        $this->setUpFaker();

        Mail::fake();

        $this->assertEmpty(WhereToEatRecommendation::all());

        $this->post('/api/wheretoeat/recommend-a-place', [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'place_name' => $this->faker->company,
            'place_location' => $this->faker->address,
            'place_web_address' => $this->faker->url,
            'place_details' => $this->faker->paragraph,
        ])->assertOk();

        $this->assertCount(1, WhereToEatRecommendation::all());
    }

    /** @test */
    public function itCanReportAPlace(): void
    {
        Event::fake(DailyUpdateItemCreated::class);

        Mail::fake();

        $eatery = $this->create(WhereToEat::class, ['name' => 'My Eatery']);

        $this->assertCount(0, WhereToEatPlaceReport::all());

        $this->setUpFaker();

        $this->post("/api/wheretoeat/{$eatery->id}/report", [
            'details' => $this->faker->paragraph,
        ])->assertOk();

        $this->assertCount(1, WhereToEatPlaceReport::all());
    }

    /** @test */
    public function itCanGetACsrfToken(): void
    {
        $this->get('/api/app-request-token')->assertOk();
    }
}
