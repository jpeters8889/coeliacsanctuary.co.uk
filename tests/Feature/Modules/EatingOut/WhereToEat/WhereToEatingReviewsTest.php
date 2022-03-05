<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatingReviewsTest extends TestCase
{
    use WithFaker;

    protected WhereToEat $whereToEat;

    protected function setUp(): void
    {
        parent::setUp();

        $this->whereToEat = $this->create(WhereToEat::class);
    }

    private function makeRequest($params = [])
    {
        return $this->post("api/wheretoeat/{$this->whereToEat->id}/reviews", array_merge([
            'rating' => 5,
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'price_range' => $this->faker->randomElement([1,2,3,4,5]),
            'comment' => $this->faker->paragraph,
        ], $params));
    }

    /** @test */
    public function itCanCreateRatings()
    {
        $this->makeRequest()->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itIsNotApprovedByDefault()
    {
        $this->makeRequest();

        $this->assertFalse($this->whereToEat->fresh()->userReviews()->first()->approved);
    }

    /** @test */
    public function itWillOnlyAllowOneRatingPerIpAddress()
    {
        $this->makeRequest()->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());

        $this->makeRequest()
            ->assertStatus(422)
            ->assertJson(['error' => 'You have already rated this location']);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itApprovesEmptyRatings()
    {
        $this->makeRequest(['name' => null, 'email' => null, 'price_range' => null, 'comment' => null])
            ->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
        $this->assertTrue($this->whereToEat->userReviews()->first()->approved);
    }

    /** @test */
    public function itErrorsWithoutARating()
    {
        $this->makeRequest(['rating' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidRating()
    {
        $this->makeRequest(['rating' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithARatingThatIsLowerThan1()
    {
        $this->makeRequest(['rating' => 0])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());

        $this->makeRequest(['rating' => -1])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithARatingThatIsGreaterThan5()
    {
        $this->makeRequest(['rating' => 6])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithoutAName()
    {
        $this->makeRequest(['name' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithoutAEmail()
    {
        $this->makeRequest(['email' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidEmail()
    {
        $this->makeRequest(['email' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidPriceRange()
    {
        $this->makeRequest(['price_range' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAPriceRangeThatIsLowerThan1()
    {
        $this->makeRequest(['price_range' => 0])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());

        $this->makeRequest(['price_range' => -1])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAPriceRangeThatIsGreaterThan5()
    {
        $this->makeRequest(['price_range' => 6])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithoutAComment()
    {
        $this->makeRequest(['comment' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }
}
