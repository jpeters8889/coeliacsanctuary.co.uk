<?php

declare(strict_types=1);

namespace Tests\Unit;

use Coeliac\Modules\Member\Listeners\FindEligibleDailyUpdatesToQueue;
use Tests\TestCase;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Blog\Models\Blog;
use Illuminate\Support\Facades\Event;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;

class DailyUpdateItemCreatedListenerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function itQueuesAnUpdateForASubscribedTag()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
    }
}
