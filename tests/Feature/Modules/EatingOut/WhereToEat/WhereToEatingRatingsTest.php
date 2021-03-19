<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Tests\Traits\CreatesWhereToEat;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatingRatingsTest extends TestCase
{
    use RefreshDatabase;
    use CreatesWhereToEat;
    use WithFaker;

    /** @var WhereToEat */
    protected $whereToEat;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->whereToEat = $this->createWhereToEat();
    }

    private function makeRequest($params = [])
    {
        return $this->post("api/wheretoeat/{$this->whereToEat->id}/reviews", array_merge([
            'rating' => 5,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'comment' => $this->faker->paragraph,
        ], $params));
    }

    /** @test */
    public function itCanCreateRatings()
    {
        $this->withoutExceptionHandling();
        $this->makeRequest()->assertStatus(200)->content();

        $this->assertEquals(1, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itIsNotApprovedByDefault()
    {
        $this->makeRequest();

        $this->assertFalse($this->whereToEat->fresh()->ratings()->first()->approved);
    }

    /** @test */
    public function itWillOnlyAllowOneRatingPerIpAddress()
    {
        $this->makeRequest()->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->ratings()->count());

        $this->makeRequest()->assertStatus(422)
        ->assertJson(['error' => 'You have already rated this location']);

        $this->assertEquals(1, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itApprovesEmptyRatings()
    {
        $this->makeRequest(['name' => null, 'email' => null, 'comment' => null])
            ->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->ratings()->count());
        $this->assertTrue($this->whereToEat->ratings()->first()->approved);
    }

    /** @test */
    public function itErrorsWithoutARating()
    {
        $this->makeRequest(['rating' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidRating()
    {
        $this->makeRequest(['rating' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itErrorsWithARatingThatIsLowerThan1()
    {
        $this->makeRequest(['rating' => 0])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());

        $this->makeRequest(['rating' => -1])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itErrorsWithARatingThatIsGreaterThan5()
    {
        $this->makeRequest(['rating' => 6])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itErrorsWithoutAName()
    {
        $this->makeRequest(['name' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itErrorsWithoutAEmail()
    {
        $this->makeRequest(['email' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidEmail()
    {
        $this->makeRequest(['email' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }

    /** @test */
    public function itErrorsWithoutAComment()
    {
        $this->makeRequest(['comment' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->ratings()->count());
    }
}
