<?php

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
        if (!$id) {
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
    public function itErrorsIfTryingToAddFeaturesThatDontExist(): void
    {
        $this->makeRequest(field: 'features', value: [1, 123])
            ->assertStatus(422)
            ->assertJsonMissingValidationErrors('value.0')
            ->assertJsonValidationErrorFor('value.1');
    }

    /** @test */
    public function itStoresTheFeaturesAsAJsonArray(): void
    {
        $this->assertEmpty(WhereToEatSuggestedEdit::all());

        $this->makeRequest(field: 'features', value: [1, 3, 5]);

        $this->assertNotEmpty(WhereToEatSuggestedEdit::all());

        $suggestedEdit = WhereToEatSuggestedEdit::query()->first();

        $this->assertEquals('features', $suggestedEdit->field);
        $this->assertEquals(json_encode([1, 3, 5]), $suggestedEdit->value);
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
}
