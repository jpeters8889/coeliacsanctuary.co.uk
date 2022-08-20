<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatOpeningTimes;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class WhereToEatSuggestEditTest extends TestCase
{
    protected WhereToEat $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eatery = $this->create(WhereToEat::class);
    }

    /** @test */
    public function itReturns404IfTheEateryDoesntExist(): void
    {
        $this->get('/api/wheretoeat/1234/suggest-edit')->assertNotFound();
    }

    /** @test */
    public function itReturns404IfTheEateryIsNotLive(): void
    {
        $eatery = $this->build(WhereToEat::class)
            ->notLive()
            ->create();

        $this->get("/api/wheretoeat/{$eatery->id}/suggest-edit")->assertNotFound();
    }

    /** @test */
    public function itReturnsOkWithAValidEatery(): void
    {
        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")->assertOk();
    }

    /**
     * @test
     * @dataProvider returnedFields
     */
    public function itContainsTheRequiredStringFields($field): void
    {
        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJsonPath("data.{$field}", $this->eatery->$field);
    }

    public function returnedFields(): array
    {
        return [['address'], ['website'], ['gf_menu_link'], ['phone']];
    }

    /** @test */
    public function itContainsTheVenueType(): void
    {
        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJsonPath('data.venue_type.id', $this->eatery->venue_type_id)
            ->assertJsonPath('data.venue_type.label', $this->eatery->venueType->venue_type);
    }

    /** @test */
    public function itDisplaysTheAvailableVenueTypes(): void
    {
        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJson(function (AssertableJson $json) {
                $json->has('data.venue_type.values');
            })
            ->assertJsonFragment([
                'values' => WhereToEatVenueType::query()
                    ->orderBy('venue_type')
                    ->get()
                    ->transform(fn (WhereToEatVenueType $venueType) => [
                        'label' => $venueType->venue_type,
                        'selected' => $venueType->id === $this->eatery->venue_type_id,
                        'value' => $venueType->id,
                    ]),
            ]);
    }

    /** @test */
    public function itContainsTheCuisine(): void
    {
        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJsonPath('data.cuisine.id', $this->eatery->cuisine_id)
            ->assertJsonPath('data.cuisine.label', $this->eatery->cuisine->cuisine);
    }

    /** @test */
    public function itDisplaysTheAvailableCuisines(): void
    {
        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJson(function (AssertableJson $json) {
                $json->has('data.cuisine.values');
            })
            ->assertJsonFragment([
                'values' => WhereToEatCuisine::query()
                    ->orderBy('cuisine')
                    ->get()
                    ->transform(fn (WhereToEatCuisine $cuisine) => [
                        'label' => $cuisine->cuisine,
                        'selected' => $cuisine->id === $this->eatery->cuisine_id,
                        'value' => $cuisine->id,
                    ]),
            ]);
    }

    /** @test */
    public function itDisplaysTheOpeningTimes(): void
    {
        $this->build(WhereToEatOpeningTimes::class)
            ->forEatery($this->eatery)
            ->create();

        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJsonStructure([
                'data' => [
                    'opening_times' => [
                        'monday' => [],
                        'tuesday' => [],
                        'wednesday' => [],
                        'thursday' => [],
                        'friday' => [],
                        'saturday' => [],
                        'sunday' => [],
                    ],
                ],
            ]);
    }

    /** @test */
    public function itDisplaysTheSelectedFeatures(): void
    {
        $features = WhereToEatFeature::query()->whereIn('id', [1, 2, 3])->get();

        $features->each(fn (WhereToEatFeature $feature) => $this->eatery->features()->attach($feature));

        $this->eatery->refresh();

        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJson(function (AssertableJson $json) {
                $json->has('data.features.selected');
            })
            ->assertJsonFragment([
                'selected' => [
                    [
                        'id' => 1,
                        'label' => $features[0]->feature,
                    ],
                    [
                        'id' => 2,
                        'label' => $features[1]->feature,
                    ],
                    [
                        'id' => 3,
                        'label' => $features[2]->feature,
                    ],
                ],
            ]);
    }

    /** @test */
    public function itDisplaysTheAvailableFeatures(): void
    {
        $this->get("/api/wheretoeat/{$this->eatery->id}/suggest-edit")
            ->assertJson(function (AssertableJson $json) {
                $json->has('data.features.values');
            })
            ->assertJsonFragment([
                'values' => WhereToEatFeature::query()
                    ->get()
                    ->transform(fn (WhereToEatFeature $feature) => [
                        'id' => $feature->id,
                        'label' => $feature->feature,
                        'selected' => in_array($feature->id, $this->eatery->features->pluck('id')->toArray()),
                    ]),
            ]);
    }
}
