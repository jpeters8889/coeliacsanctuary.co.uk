<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Dashboard;

use Tests\Abstracts\DashboardTest;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Contracts\Updatable;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\UserDailyUpdateSubscription;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

class MemberDashboardDailyUpdatesTest extends DashboardTest
{
    protected BlogTag $blogTag;

    protected function page(): string
    {
        return 'daily-updates';
    }

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->blogTag = factory(BlogTag::class)->create();
    }

    protected function makeSubscribeRequest($type = DailyUpdateType::BLOG_TAGS, $updatable = null, $prop = 'slug')
    {
        if ($updatable === null) {
            $updatable = $this->blogTag;
        }

        return $this->post('/api/member/dashboard/daily-updates', [
            'type' => $type,
            'updatable' => $updatable instanceof Updatable ? $updatable->$prop : $updatable,
        ]);
    }

    /** @test */
    public function itErrorsWhenSubscribingWithoutAType()
    {
        $this->makeSubscribeRequest(null)->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSubscribingWithAnInvalidType()
    {
        $this->makeSubscribeRequest('foo')->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSubscribingToATypeThatDoesntExist()
    {
        $this->makeSubscribeRequest(999)->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSubscribingWithoutAnUpdatable()
    {
        $this->makeSubscribeRequest(DailyUpdateType::BLOG_TAGS, false)->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToSubscribeToAUpdatableThatDoesntExist()
    {
        $this->makeSubscribeRequest(DailyUpdateType::BLOG_TAGS, 'foo')->assertStatus(422);
    }

    /** @test */
    public function itReturnsOkOnTheSubscribePageWithValidData()
    {
        $this->makeSubscribeRequest()->assertOk();
    }

    /** @test */
    public function itSubscribesTheUser()
    {
        $this->assertEmpty(UserDailyUpdateSubscription::all());

        $this->makeSubscribeRequest()->assertOk();

        $this->assertNotEmpty(UserDailyUpdateSubscription::all());

        /** @var UserDailyUpdateSubscription $subscription */
        $subscription = UserDailyUpdateSubscription::query()->first();

        $this->assertEquals($this->user->id, $subscription->user_id);
        $this->assertEquals(DailyUpdateType::BLOG_TAGS, $subscription->daily_update_type_id);
        $this->assertInstanceOf(BlogTag::class, $subscription->updatable);
        $this->assertTrue($this->blogTag->is($subscription->updatable));
    }

    /** @test */
    public function itCanUnsubscribe()
    {
        $this->makeSubscribeRequest();

        $this->assertNotEmpty(UserDailyUpdateSubscription::all());

        /** @var UserDailyUpdateSubscription $subscription */
        $subscription = UserDailyUpdateSubscription::query()->first();

        $this->delete("/api/member/dashboard/daily-updates/{$subscription->id}")->assertOk();

        $this->assertEmpty(UserDailyUpdateSubscription::all());
    }

    /** @test */
    public function itErrorsIfTheSubscriptionDoesntExist()
    {
        $this->delete('/api/member/dashboard/daily-updates/foo')->assertStatus(404);
    }

    /** @test */
    public function itErrorsWhenTryingToUnsubscribeFromAnotherUsersSubscriptions()
    {
        $user = factory(User::class)->create();

        DailyUpdateType::query()->first()->subscribe($user, $this->blogTag);

        $this->assertNotEmpty(UserDailyUpdateSubscription::all());

        /** @var UserDailyUpdateSubscription $subscription */
        $subscription = UserDailyUpdateSubscription::query()->first();

        $this->delete("/api/member/dashboard/daily-updates/{$subscription->id}")->assertStatus(403);

        $this->assertNotEmpty(UserDailyUpdateSubscription::all());
    }

    /** @test */
    public function itErrorsWhenSearchingForAnExistingSubscriptionWithoutAType()
    {
        $this->post('/api/member/dashboard/daily-updates/search', [
            'type' => null,
            'updatable' => 'foo',
        ])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSearchingForAnExistingSubscriptionWithAnInvalidType()
    {
        $this->post('/api/member/dashboard/daily-updates/search', [
            'type' => 'foo',
            'updatable' => 'bar',
        ])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSearchingForASubscriptionWhenTheTypeDoesntExist()
    {
        $this->post('/api/member/dashboard/daily-updates/search', [
            'type' => 999,
            'updatable' => 'foo',
        ])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSearchingForAnExistingSubscriptionWithoutAnUpdatable()
    {
        $this->post('/api/member/dashboard/daily-updates/search', [
            'type' => DailyUpdateType::BLOG_TAGS,
            'daily-updates' => null,
        ])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenSearchingForAnExistingSubscriptionWithAnUpdatableThatDoesntExist()
    {
        $this->post('/api/member/dashboard/daily-updates/search', [
            'type' => DailyUpdateType::BLOG_TAGS,
            'updatable' => 'foo',
        ])->assertStatus(422);
    }

    /** @test */
    public function itCanFindOutWhetherAnUpdatableExists()
    {
        $this->makeSubscribeRequest();

        $subscription = UserDailyUpdateSubscription::query()->first();

        $this->post('/api/member/dashboard/daily-updates/search', [
            'type' => DailyUpdateType::BLOG_TAGS,
            'updatable' => $this->blogTag->slug,
        ])
            ->assertOk()
            ->assertJson(['id' => $subscription->id]);
    }

    /** @test */
    public function itReturnsNoContentWhenNotSubscribedToAnUpdatable()
    {
        $this->post('/api/member/dashboard/daily-updates/search', [
            'type' => DailyUpdateType::BLOG_TAGS,
            'updatable' => $this->blogTag->slug,
        ])->assertStatus(204);
    }

    /** @test */
    public function itReturnsTheUsersSubscriptionsOnTheSubscriptionListEndpoint()
    {
        $this->makeSubscribeRequest();

        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        $this->makeSubscribeRequest(DailyUpdateType::WTE_COUNTY, $county, 'id');
        $this->makeSubscribeRequest(DailyUpdateType::WTE_TOWN, $town, 'id');

        $request = $this->makeApiRequest();

        $this->assertIsArray($request->json());
        $request->assertJsonStructure([[
            'id',
            'type' => [
                'id',
                'name',
            ],
            'updatable' => [
                'id',
                'name',
                'link',
            ],
        ]]);
    }
}
