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
            'food_rating' => $this->faker->randomElement(['poor', 'good', 'excellent']),
            'service_rating' => $this->faker->randomElement(['poor', 'good', 'excellent']),
            'expense' => $this->faker->randomElement([1,2,3,4,5]),
            'comment' => $this->faker->paragraph,
        ], $params));
    }

    /** @test */
    public function itCanCreateRatings(): void
    {
        $this->makeRequest()->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itIsNotApprovedByDefault(): void
    {
        $this->makeRequest();

        $this->assertFalse($this->whereToEat->fresh()->userReviews()->first()->approved);
    }

    /** @test */
    public function itWillOnlyAllowOneRatingPerIpAddress(): void
    {
        $this->makeRequest()->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());

        $this->makeRequest()
            ->assertStatus(422)
            ->assertJson(['error' => 'You have already rated this location']);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itApprovesEmptyRatings(): void
    {
        $this->makeRequest([
            'name' => null, 'email' => null, 'food_rating' => null, 'service_rating' => null,
            'expense' => null, 'comment' => null
        ])->assertStatus(200);

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
        $this->assertTrue($this->whereToEat->userReviews()->first()->approved);
    }

    /** @test */
    public function itErrorsWithoutARating(): void
    {
        $this->makeRequest(['rating' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidRating(): void
    {
        $this->makeRequest(['rating' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithARatingThatIsLowerThan1(): void
    {
        $this->makeRequest(['rating' => 0])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());

        $this->makeRequest(['rating' => -1])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithARatingThatIsGreaterThan5(): void
    {
        $this->makeRequest(['rating' => 6])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithoutAName(): void
    {
        $this->makeRequest(['name' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithoutAEmail(): void
    {
        $this->makeRequest(['email' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidEmail(): void
    {
        $this->makeRequest(['email' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidHowExpensiveValue(): void
    {
        $this->makeRequest(['expense' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnHowExpensiveValueThatIsLowerThan1(): void
    {
        $this->makeRequest(['expense' => 0])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());

        $this->makeRequest(['expense' => -1])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnHowExpensiveValueThatIsGreaterThan5(): void
    {
        $this->makeRequest(['expense' => 6])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidFoodRatingValue(): void
    {
        $this->makeRequest(['food' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithAnInvalidServiceRatingValue(): void
    {
        $this->makeRequest(['service' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsWithoutAComment(): void
    {
        $this->makeRequest(['comment' => null])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }
}
