<?php

declare(strict_types=1);

namespace Tests\Architect;

use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;
use Tests\Traits\CreatesWhereToEat;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JPeters\Architect\TestHelpers\Traits\LogsInUsers;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;
use Coeliac\Modules\EatingOut\WhereToEat\Notifications\WhereToEatRatingApprovedNotification;

class WhereToEatRatingApiCallTest extends TestCase
{
    use RefreshDatabase;
    use CreatesWhereToEat;
    use LogsInUsers;

    private ?WhereToEatRating $rating = null;

    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->logIn(factory(User::class)->create(['email' => 'jamie@jamie-peters.co.uk']));

        $eatery = $this->createWhereToEat();

        $this->rating = $eatery->ratings()->create(factory(WhereToEatRating::class)->raw(['email' => 'jamie@foo.com']));
    }

    /** @test */
    public function itDeletesRatings()
    {
        $this->delete('/cs-adm/api/external/coeliac-wte-ratings/delete/'.$this->rating->id)->assertStatus(200);

        $this->assertDeleted($this->rating);
    }

    /** @test */
    public function itCanApproveComments()
    {
        Notification::fake();

        $this->assertEquals(0, $this->rating->approved);

        $this->put('/cs-adm/api/external/coeliac-wte-ratings/approve/'.$this->rating->id);

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            WhereToEatRatingApprovedNotification::class,
            function (WhereToEatRatingApprovedNotification $notification, $channels, AnonymousNotifiable $notifiable) {
                $checks = [
                    $notifiable->routes['mail'] === 'jamie@foo.com',
                    $notification->rating()->is($this->rating),
                    in_array('mail', $channels),
                ];

                return !in_array(false, $checks);
            }
        );

        $this->assertEquals(1, $this->rating->fresh()->approved);
    }
}
