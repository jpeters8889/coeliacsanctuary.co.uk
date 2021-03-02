<?php

declare(strict_types=1);

namespace Tests\Unit;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdatesQueue;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Models\User;
use Tests\TestCase;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\Member\Events\DailyUpdateItemCreated;

class DailyUpdateItemCreatedListenerTest extends TestCase
{
    use RefreshDatabase;

    protected function createEvent(BaseModel $model, int $type)
    {
        return new DailyUpdateItemCreated($model, $type);
    }

    /** @test */
    public function itQueuesAnUpdateForASubscribedTag()
    {
        $user = factory(User::class)->create();
        $tag = factory(BlogTag::class)->create();

        DailyUpdateType::query()->find(DailyUpdateType::BLOG_TAGS)->subscribe($user, $tag);

        $blog = factory(Blog::class)->create();
        $blog->tags()->attach($tag);

        $this->assertEmpty(DailyUpdatesQueue::all());

        $this->createEvent($blog, DailyUpdateType::BLOG_TAGS);

        $this->assertNotEmpty(DailyUpdatesQueue::all());
    }
}
