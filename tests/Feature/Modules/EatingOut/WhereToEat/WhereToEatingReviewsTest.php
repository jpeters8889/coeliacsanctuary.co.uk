<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\EatingOut\WhereToEat;

use Coeliac\Common\Models\TemporaryFileUpload;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PrepareWhereToEatReviewImages;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Support\Facades\Event;
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

        Event::fake([PrepareWhereToEatReviewImages::class]);

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
            'expense' => $this->faker->randomElement([1, 2, 3, 4, 5]),
            'comment' => $this->faker->paragraph,
            'images' => [],
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

    /** @test */
    public function itErrorsIfImagesIsntAnArray(): void
    {
        $this->makeRequest(['images' => null])->assertStatus(422);
        $this->makeRequest(['images' => 'foo'])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsIfImagesHasMoreThanSixItems(): void
    {
        $this->makeRequest(['images' => [1, 2, 3, 4, 5, 6, 7]])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsIfTheImageArrayItemsArentStrings(): void
    {
        $this->makeRequest(['images' => [1]])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itErrorsIfTheGivenImageItemDoesntExistInTheTemporaryUploadsTable(): void
    {
        $this->assertEmpty(TemporaryFileUpload::all());

        $this->makeRequest(['images' => ['foo']])->assertStatus(422);

        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itReturnsOkIfTheImageDoesExist(): void
    {
        $upload = $this->create(TemporaryFileUpload::class);

        $this->makeRequest(['images' => [$upload->id]])->assertOk();
    }

    /** @test */
    public function itStoresRatings(): void
    {
        $this->assertEquals(0, $this->whereToEat->fresh()->userReviews()->count());

        $this->makeRequest()->assertOk();

        $this->assertEquals(1, $this->whereToEat->fresh()->userReviews()->count());
    }

    /** @test */
    public function itStoresFullRatingsAsNotApproved(): void
    {
        $this->makeRequest()->assertOk();

        $this->assertFalse($this->whereToEat->fresh()->userReviews->first()->approved);
    }

    /** @test */
    public function itDoesntDispatchAnImageJobWhenTheRequestFails(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $this->makeRequest(['name' => null]);

        Event::assertNothingDispatched();
    }

    /** @test */
    public function itDoesntDispatchAnImageJobWhenTheRequestDoesntHaveImages(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $this->makeRequest();

        Event::assertNothingDispatched();
    }

    /** @test */
    public function itDispatchesAnImageJobWhenTheRequestIsValidAndHasImages(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $upload = $this->create(TemporaryFileUpload::class);

        $this->makeRequest(['images' => [$upload->id]]);

        Event::assertDispatched(PrepareWhereToEatReviewImages::class);
    }

    /** @test */
    public function itErrorsIfSubmittingAsAnAdminReviewWhenNotLoggedIn(): void
    {
        $this->makeRequest(['admin_review' => true])->assertStatus(422);
    }

    /** @test */
    public function itErrorsIfSubmittingAsAnAdminReviewWhenLoggedInAsANormalUser(): void
    {
        $this->actingAs($this->create(User::class))
            ->makeRequest(['admin_review' => true])
            ->assertStatus(422);
    }

    /** @test */
    public function itAllowsSubmittingAsAnAdminReviewWhenLoggedInAsAdmin(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $this->asAdmin()
            ->makeRequest(['admin_review' => true])
            ->assertOk();
    }

    /** @test */
    public function itStoresAdminReviewAsFalseByDefault(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $this->makeRequest()->assertOk();

        $review = $this->whereToEat->refresh()->userReviews[0];

        $this->assertFalse($review->admin_review);
    }

    /** @test */
    public function itStoresTheAdminReviewAsFalseWhenSentAsFalseByAnAdmin(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $this->asAdmin()->makeRequest(['admin_review' => false]);

        $review = $this->whereToEat->refresh()->userReviews[0];

        $this->assertFalse($review->admin_review);
    }

    /** @test */
    public function itStoresTheAdminReviewAsTrueWhenSentAsTrueByAnAdmin(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $this->asAdmin()->makeRequest(['admin_review' => true]);

        $review = $this->whereToEat->refresh()->userReviews[0];

        $this->assertTrue($review->admin_review);
    }

    /** @test */
    public function itAutomaticallySetsTheReviewAsApprovedWhenSendingAsAnAdminReview(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $this->asAdmin()->makeRequest(['admin_review' => true]);

        $review = $this->whereToEat->refresh()->userReviews[0];

        $this->assertTrue($review->approved);
    }

    /** @test */
    public function itProcessesImagesWithAdminReviews(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        $upload = $this->create(TemporaryFileUpload::class);

        $this->asAdmin()->makeRequest(['images' => [$upload->id], 'admin_review' => true]);

        Event::assertDispatched(PrepareWhereToEatReviewImages::class);
    }

    /** @test */
    public function itErrorsWhenSendingABranchNameOnNonNationwidePlaces(): void
    {
        $this->makeRequest(['branch_name' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWithoutABranchNameOnNationwidePages(): void
    {
        WhereToEatCounty::query()->first()->update(['county' => 'Nationwide']);

        $this->makeRequest(['branch_name' => null])->assertStatus(422);
    }

    /** @test */
    public function itReturnsOkOnNationwidePagesWithABranchName(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        WhereToEatCounty::query()->first()->update(['county' => 'Nationwide']);

        $this->makeRequest(['branch_name' => 'foo'])->assertOk();
    }

    /** @test */
    public function itStoresTheBranchName(): void
    {
        WhereToEatCounty::query()->first()->update(['county' => 'Nationwide']);

        $this->makeRequest(['branch_name' => 'Foo']);

        $review = $this->whereToEat->refresh()->userReviews[0];

        $this->assertNotNull($review->branch_name);
        $this->assertEquals('Foo', $review->branch_name);
    }

    /** @test */
    public function itSubmitsImages(): void
    {
        Event::fake(PrepareWhereToEatReviewImages::class);

        WhereToEatCounty::query()->first()->update(['county' => 'Nationwide']);

        $upload = $this->create(TemporaryFileUpload::class);

        $this->asAdmin()->makeRequest(['images' => [$upload->id], 'branch_name' => 'foo']);

        Event::assertDispatched(PrepareWhereToEatReviewImages::class);
    }
}
