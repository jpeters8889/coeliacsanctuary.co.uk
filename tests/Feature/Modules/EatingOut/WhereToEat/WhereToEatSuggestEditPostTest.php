<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatSuggestedEdit;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

class WhereToEatSuggestEditPostTest extends TestCase
{
    use WithFaker;

    protected WhereToEat $eatery;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eatery = $this->create(WhereToEat::class);
    }

    protected function makeRequest($id = null, $field = 'address', $value = 'foo'): TestResponse
    {
        if (! $id) {
            $id = $this->eatery->id;
        }

        return $this->post("/api/wheretoeat/{$id}/suggest-edit", [
            'ip' => $this->faker->ipv4,
            'field' => $field,
            'value' => $value,
        ]);
    }

    /** @test */
    public function itReturns404IfTheEateryDoesntExist(): void
    {
        $this->makeRequest(1234)->assertNotFound();
    }

    /** @test */
    public function itReturns404IfTheEateryIsNotLive(): void
    {
        $eatery = $this->build(WhereToEat::class)
            ->notLive()
            ->create();

        $this->makeRequest($eatery->id)->assertNotFound();
    }

    /** @test */
    public function itErrorsIfTheFieldTypeIsntKnown(): void
    {
        $this->makeRequest(field: 'foo')
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('field');
    }

    /** @test */
    public function itErrorsIfThereIsNoAddressValue(): void
    {
        $this->makeRequest(field: 'address', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itCreatesASuggestedEditForTheAddress(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $this->makeRequest();

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('address', $suggestedEdit->field);
        $this->assertEquals('foo', $suggestedEdit->value);
    }

    /** @test */
    public function itFormatsTheAddressBeforeSaving(): void
    {
        $this->makeRequest(value: "Foo\nBar\nBaz");

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('Foo<br />Bar<br />Baz', $suggestedEdit->value);
    }

    /** @test */
    public function itErrorsIfThereIsNoCuisineValue(): void
    {
        $this->makeRequest(field: 'cuisine', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTryingToSubmitACuisineThatDoesntExist(): void
    {
        $this->makeRequest(field: 'cuisine', value: 123)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itStoresASuggestedEditForCuisine(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $this->makeRequest(field: 'cuisine', value: 1);

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('cuisine', $suggestedEdit->field);
        $this->assertEquals('1', $suggestedEdit->value);
    }

    /** @test */
    public function itErrorsIfThereIsNoFeaturesValue(): void
    {
        $this->makeRequest(field: 'features', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTryingToAddFeaturesThatArentAnArray(): void
    {
        $this->makeRequest(field: 'features', value: 123)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsWithOutTheCorrectFeatureFormat(): void
    {
        $this->makeRequest(field: 'features', value: [['foo' => 'bar']])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.key')
            ->assertJsonValidationErrorFor('value.0.label')
            ->assertJsonValidationErrorFor('value.0.selected');
    }

    /** @test */
    public function itErrorsIfTryingToAddFeaturesThatDontExist(): void
    {
        $this->makeRequest(field: 'features', value: [
            ['key' => 1, 'label' => 'Foo', 'selected' => true],
            ['key' => 123, 'label' => 'Bar', 'selected' => true],
        ])
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('value.0.key')
            ->assertJsonValidationErrorFor('value.1.key');
    }

    /** @test */
    public function itStoresTheFeaturesAsAJsonArray(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $features = [
            ['key' => 1, 'label' => 'Foo', 'selected' => true],
            ['key' => 3, 'label' => 'Bar', 'selected' => true],
            ['key' => 5, 'label' => 'Baz', 'selected' => true],
        ];

        $this->makeRequest(field: 'features', value: $features);

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('features', $suggestedEdit->field);
        $this->assertEquals(json_encode($features), $suggestedEdit->value);
    }

    /** @test */
    public function itErrorsIfThereIsNoGfMenuLinkValue(): void
    {
        $this->makeRequest(field: 'gf_menu_link', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTryingToSubmitAGfMenuLinkThatIsntAUrl(): void
    {
        $this->makeRequest(field: 'gf_menu_link', value: 'foobar')
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itStoresTheGfMenuLink(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $this->makeRequest(field: 'gf_menu_link', value: $url = $this->faker->url());

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('gf_menu_link', $suggestedEdit->field);
        $this->assertEquals($url, $suggestedEdit->value);
    }

    /** @test */
    public function itErrorsIfThereIsNoOpeningTimesValue(): void
    {
        $this->makeRequest(field: 'opening_times', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTryingToAddOpeningTimesThatArentAnArray(): void
    {
        $this->makeRequest(field: 'opening_times', value: 123)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTryingToAddOpeningTimesThatDoesntHaveSevenItems(): void
    {
        $this->makeRequest(field: 'opening_times', value: [1, 2, 3, 4, 5, 6])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');

        $this->makeRequest(field: 'opening_times', value: [1, 2, 3, 4, 5, 6, 7, 8])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesKeyIsntValid(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['key' => 'foo']])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.key');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesLabelIsntValid(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['label' => 'foo']])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.label');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesStartIsntAnArray(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['start' => 'foo']])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.start');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesStartIsntAnArrayWithTwoItems(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['start' => ['foo']]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.start');

        $this->makeRequest(field: 'opening_times', value: [['start' => ['foo', 'bar', 'baz']]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.start');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesStartIsntAnArrayOfNumbers(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['start' => ['foo', 'bar']]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.start.0')
            ->assertJsonValidationErrorFor('value.0.start.1');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesStartHourIsntCorrect(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['start' => [50, 30]]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.start.0');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesStartMinuteIsntCorrect(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['start' => [12, 35]]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.start.1');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesEndIsntAnArray(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['end' => 'foo']])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.end');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesEndIsntAnArrayWithTwoItems(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['end' => ['foo']]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.end');

        $this->makeRequest(field: 'opening_times', value: [['end' => ['foo', 'bar', 'baz']]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.end');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesEndIsntAnArrayOfNumbers(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['end' => ['foo', 'bar']]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.end.0')
            ->assertJsonValidationErrorFor('value.0.end.1');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesEndHourIsntCorrect(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['end' => [50, 30]]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.end.0');
    }

    /** @test */
    public function itErrorsIfTheOpeningTimesEndMinuteIsntCorrect(): void
    {
        $this->makeRequest(field: 'opening_times', value: [['end' => [12, 35]]])
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value.0.end.1');
    }

    /** @test */
    public function itStoresTheOpeningTimesAsAJsonArray(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $openingTimes = [
            ['key' => 'monday', 'label' => 'Monday', 'start' => [12, 0], 'end' => [20, 30]],
            ['key' => 'tuesday', 'label' => 'Tuesday', 'start' => [12, 0], 'end' => [20, 30]],
            ['key' => 'wednesday', 'label' => 'Wednesday', 'start' => [12, 0], 'end' => [20, 30]],
            ['key' => 'thursday', 'label' => 'Thursday', 'start' => [12, 0], 'end' => [20, 30]],
            ['key' => 'friday', 'label' => 'Friday', 'start' => [12, 0], 'end' => [20, 30]],
            ['key' => 'saturday', 'label' => 'Saturday', 'start' => [12, 0], 'end' => [20, 30]],
            ['key' => 'sunday', 'label' => 'Sunday', 'start' => [12, 0], 'end' => [20, 30]],
        ];

        $this->makeRequest(field: 'opening_times', value: $openingTimes);

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('opening_times', $suggestedEdit->field);
        $this->assertEquals(json_encode($openingTimes), $suggestedEdit->value);
    }

    /** @test */
    public function itErrorsIfThereIsNoPhoneValue(): void
    {
        $this->makeRequest(field: 'phone', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itStoresPhoneLink(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $this->makeRequest(field: 'phone', value: '123456');

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('phone', $suggestedEdit->field);
        $this->assertEquals('123456', $suggestedEdit->value);
    }

    /** @test */
    public function itErrorsIfThereIsNoVenueTypeValue(): void
    {
        $this->makeRequest(field: 'venue_type', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTryingToSubmitAVenueTypeThatDoesntExist(): void
    {
        $this->makeRequest(field: 'venue_type', value: 123)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itStoresASuggestedEditForVenueType(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $this->makeRequest(field: 'venue_type', value: 1);

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('venue_type', $suggestedEdit->field);
        $this->assertEquals('1', $suggestedEdit->value);
    }

    /** @test */
    public function itErrorsIfThereIsNoWebsiteValue(): void
    {
        $this->makeRequest(field: 'website', value: null)
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itErrorsIfTryingToSubmitAWebsiteThatIsntAUrl(): void
    {
        $this->makeRequest(field: 'website', value: 'foobar')
            ->assertStatus(422)
            ->assertJsonValidationErrorFor('value');
    }

    /** @test */
    public function itStoresTheWebsite(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $this->makeRequest(field: 'website', value: $url = $this->faker->url());

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('website', $suggestedEdit->field);
        $this->assertEquals($url, $suggestedEdit->value);
    }
}
