<?php

declare(strict_types=1);

namespace Tests\Feature;

use Carbon\Carbon;
use Tests\TestCase;
use Spatie\TestTime\TestTime;
use Illuminate\Testing\TestResponse;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Competition\Models\Competition;
use Coeliac\Modules\Competition\Models\CompetitionEntry;

class CompetitionEntryTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    protected Competition $competition;

    protected function setUp(): void
    {
        parent::setUp();

        TestTime::freeze();
        $this->competition = factory(Competition::class)->create(['start_at' => Carbon::now()]);
    }

    protected function makeRequest(array $params = []): TestResponse
    {
        return $this->post("/api/competition/{$this->competition->uuid}", array_merge([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
        ], $params));
    }

    protected function makeExtraEntryRequest($params = []): TestResponse
    {
        return $this->put("/api/competition/{$this->competition->uuid}", array_merge([
            'id' => $this->competition->entries()->first()->id ?? null,
            'type' => 'facebook_like',
        ], $params));
    }

    /** @test */
    public function itReturns404IfTheCompetitionIsntActive()
    {
        TestTime::subMonth();

        $this->makeRequest()->assertStatus(404);
    }

    /** @test */
    public function itReturns404IfTheCompetitionIsActiveButNotOpenForEntries()
    {
        TestTime::subDays(5);

        $this->makeRequest()->assertStatus(404);
    }

    /** @test */
    public function itErrorsWithoutAName()
    {
        $this->makeRequest(['name' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithoutAnEmail()
    {
        $this->makeRequest(['email' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithAnInvalidEmail()
    {
        $this->makeRequest(['email' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itReturnsOk()
    {
        $this->makeRequest()->assertOk();
    }

    /** @test */
    public function itStoresTheCompetitionEntry()
    {
        $this->assertEmpty(CompetitionEntry::all());

        $this->makeRequest([
            'name' => 'Jamie',
            'email' => 'foo@bar.com',
        ]);

        $this->assertNotEmpty(CompetitionEntry::all());
        $this->assertCount(1, $this->competition->fresh()->entries);

        /** @var CompetitionEntry $entry */
        $entry = $this->competition->entries()->first();

        $this->assertEquals('Jamie', $entry->name);
        $this->assertEquals('foo@bar.com', $entry->email);
        $this->assertEquals('primary', $entry->entry_type);
    }

    /** @test */
    public function it_errors_if_the_user_has_already_entered_the_competition()
    {
        $params = [
            'name' => 'Jamie',
            'email' => 'foo@bar.com',
        ];

        $this->makeRequest($params);

        $this->assertCount(1, $this->competition->fresh()->entries);

        $this->makeRequest($params)->assertStatus(422)->assertJsonFragment(['error' => 'duplicate entry']);

        $this->assertCount(1, $this->competition->fresh()->entries);
    }

    /** @test */
    public function it_returns_the_entry_uuid()
    {
        $request = $this->makeRequest();

        $request->assertJsonStructure(['id']);

        /** @var CompetitionEntry $entry */
        $entry = $this->competition->entries()->first();

        $this->assertEquals($entry->id, $request->json('id'));
    }

    /** @test */
    public function it_errors_when_trying_to_make_an_additional_entry_to_a_competition_that_isnt_active()
    {
        TestTime::subMonth();

        $this->makeExtraEntryRequest(['id' => 'foo'])->assertStatus(404);
    }

    /** @test */
    public function itReturns404WhenMakingAdditionalEntriesIfTheCompetitionIsActiveButNotOpenForEntries()
    {
        TestTime::subDays(5);

        $this->makeExtraEntryRequest(['id' => 'foo'])->assertStatus(404);
    }

    /** @test */
    public function it_errors_without_an_id()
    {
        $this->makeExtraEntryRequest()->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_invalid_key()
    {
        $this->makeRequest();

        $this->makeExtraEntryRequest(['id' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_without_a_type()
    {
        $this->makeRequest();
        $this->makeExtraEntryRequest(['type' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_with_an_invalid_type()
    {
        $this->makeRequest();
        $this->makeExtraEntryRequest(['type' => 'foo'])->assertStatus(422);
    }

    /**
     * @test
     * @dataProvider entryTypesDataProvider
     */
    public function it_errors_if_the_entry_type_is_disabled($column, $type)
    {
        $this->makeRequest();

        $this->competition->update([$column => 0]);

        $this->makeExtraEntryRequest(['type' => $type])->assertStatus(422);
    }

    public function entryTypesDataProvider()
    {
        return [
          ['enable_facebook_like', 'facebook_like'],
          ['enable_facebook_share', 'facebook_share'],
          ['enable_twitter_tweet', 'twitter_tweet'],
          ['enable_twitter_follow', 'twitter_follow'],
          ['enable_shop_purchase', 'shop_purchase'],
        ];
    }

    /** @test */
    public function it_returns_ok()
    {
        $this->makeRequest();
        $this->makeExtraEntryRequest()->assertOk();
    }

    /** @test */
    public function it_stores_the_additional_entry()
    {
        $this->makeRequest([
            'name' => 'Jamie',
            'email' => 'foo@bar.com',
        ]);

        $this->assertCount(1, $this->competition->fresh()->entries);

        $this->makeExtraEntryRequest(['type' => 'facebook_like']);

        $this->assertCount(2, $this->competition->fresh()->entries);

        $entry = $this->competition->entries()->latest()->first();

        $this->assertEquals('Jamie', $entry->name);
        $this->assertEquals('foo@bar.com', $entry->email);
        $this->assertEquals('facebook_like', $entry->entry_type);
    }

    /** @test */
    public function it_errors_on_duplicate_additional_entry()
    {
        $request = $this->makeRequest();
        $id = $request->json('id');

        $this->makeExtraEntryRequest(['id' => $id, 'type' => 'facebook_like']);

        $this->assertCount(2, $this->competition->fresh()->entries);

        $this->makeExtraEntryRequest(['id' => $id, 'type' => 'facebook_like'])->assertStatus(422);

        $this->assertCount(2, $this->competition->fresh()->entries);
    }
}
