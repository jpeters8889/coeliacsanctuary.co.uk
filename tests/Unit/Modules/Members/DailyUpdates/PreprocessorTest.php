<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\Member\Services\DailyUpdatePreprocessor;
use Illuminate\Support\Collection;
use Tests\TestCase;

class PreprocessorTest extends TestCase
{
    /** @test */
    public function itReturnsABlogsAndEateriesKeys()
    {
        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection());
        $results = $processor->process();

        $this->assertTrue($results->has(['blogs']));
        $this->assertTrue($results->has(['eateries']));
    }

    /** @test */
    public function itReturnsItemsInTheBlog()
    {
        $processor = new DailyUpdatePreprocessor(
            new Collection(),
            new Collection([$this->create(Blog::class)])
        );

        $result = $processor->process();

        $this->assertTrue($result->get('blogs')->has('subscriptions'));
        $this->assertTrue($result->get('blogs')->has('items'));
        $this->assertCount(1, $result->get('blogs')->get('items'));
    }

    /** @test */
    public function itReturnsTheBlogFormattedWithTheCorrectKeys()
    {
        $processor = new DailyUpdatePreprocessor(
            new Collection(),
            new Collection([
                $this->build(Blog::class)
                    ->has($this->build(BlogTag::class), 'tags')
                    ->create(),
            ])
        );

        $this->assertArrayHasStructure(
            ['title', 'link', 'description', 'image'],
            $processor->process()->get('blogs')->get('items')->first()
        );
    }

    /** @test */
    public function itReturnsTheSubscribedBlogTags()
    {
        $blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class), 'tags')
            ->create()
            ->load('tags');

        $processor = new DailyUpdatePreprocessor(
            new Collection([$blog->tags[0]]),
            new Collection([$blog])
        );

        $result = $processor->process();

        $this->assertCount(1, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itReturnsMultipleBlogs()
    {
        $this->build(Blog::class)
            ->count(2)
            ->has($this->build(BlogTag::class), 'tags')
            ->create();

        $processor = new DailyUpdatePreprocessor(new Collection(BlogTag::all()), new Collection(Blog::all()));
        $result = $processor->process();

        $this->assertCount(2, $result->get('blogs')->get('items'));
        $this->assertCount(2, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itWontIncludeDuplicateBlogs()
    {
        $blog = $this->create(Blog::class);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$blog, $blog]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('blogs')->get('items'));
    }

    /** @test */
    public function itWontIncludeDuplicateTags()
    {
        [$blog1, $blog2] = $this->build(Blog::class)
            ->count(2)
            ->has($this->build(BlogTag::class), 'tags')
            ->create();

        $tag = $this->create(BlogTag::class);

        $blog1->tags()->attach($tag);
        $blog2->tags()->attach($tag);

        $processor = new DailyUpdatePreprocessor(new Collection(BlogTag::all()), new Collection(Blog::all()));
        $result = $processor->process();

        $this->assertCount(3, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itWontIncludeTagsYourNotSubscribedTo()
    {
        $blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class)->count(2), 'tags')
            ->create();

        $processor = new DailyUpdatePreprocessor(
            new Collection([BlogTag::query()->first()]),
            new Collection([$blog])
        );

        $result = $processor->process();

        $this->assertCount(1, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itWillIncludeAnEatery()
    {
        $eatery = $this->create(WhereToEat::class);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$eatery]));
        $result = $processor->process();

        $this->assertTrue($result->get('eateries')->has('subscriptions'));
        $this->assertTrue($result->get('eateries')->has('items'));
        $this->assertCount(1, $result->get('eateries')->get('items'));
    }

    /** @test */
    public function itReturnsTheItemFormattedCorrectly()
    {
        $eatery = $this->create(WhereToEat::class);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$eatery]));
        $item = $processor->process()->get('eateries')->get('items')->first();

        $this->assertArrayHasStructure(['title', 'link', 'description', 'address'], $item);
    }

    /** @test */
    public function itReturnsTheSubscribedItems()
    {
        $eatery = $this->create(WhereToEat::class);

        $processor = new DailyUpdatePreprocessor(
            new Collection([WhereToEatCounty::query()->first()]),
            new Collection([$eatery])
        );
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('subscriptions'));
    }

    /** @test */
    public function itReturnsMultipleEateries()
    {
        $eatery = $this->create(WhereToEat::class);

        $blog = $this->build(Blog::class)
            ->has($this->build(BlogTag::class), 'tags')
            ->create();

        $processor = new DailyUpdatePreprocessor(
            new Collection([
                WhereToEatCounty::query()->first(),
                BlogTag::query()->first(),
            ]),
            new Collection([$eatery, $blog])
        );

        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('items'));
        $this->assertCount(1, $result->get('blogs')->get('items'));
    }

    /** @test */
    public function itWontIncludeDuplicateEateries()
    {
        $eatery = $this->create(WhereToEat::class);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$eatery, $eatery]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('items'));
    }

    /** @test */
    public function itWontIncludeDuplicateCounties()
    {
        $this->build(WhereToEat::class)
            ->count(2)
            ->create();

        $processor = new DailyUpdatePreprocessor(
            new Collection([WhereToEatCounty::query()->first()]),
            new Collection(WhereToEat::all())
        );

        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('subscriptions'));
    }

    /** @test */
    public function itWillOnlyIncludeTheItemOnceIfYourSubscribedToBothCountyAndTown()
    {
        $eatery = $this->create(WhereToEat::class);

        $processor = new DailyUpdatePreprocessor(
            new Collection([
                WhereToEatCounty::query()->first(),
                WhereToEatTown::query()->first(),
            ]),
            new Collection([$eatery])
        );

        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('items'));
        $this->assertCount(2, $result->get('eateries')->get('subscriptions'));
    }
}
