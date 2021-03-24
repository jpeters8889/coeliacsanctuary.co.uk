<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Members\DailyUpdates;

use Tests\TestCase;
use Illuminate\Support\Collection;
use Tests\Traits\CreatesWhereToEat;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\Member\Services\DailyUpdatePreprocessor;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

class PreprocessorTest extends TestCase
{
    use CreatesWhereToEat;
    use RefreshDatabase;

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
        $blog = factory(Blog::class)->create();

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$blog]));
        $result = $processor->process();

        $this->assertTrue($result->get('blogs')->has('subscriptions'));
        $this->assertTrue($result->get('blogs')->has('items'));
        $this->assertCount(1, $result->get('blogs')->get('items'));
    }

    /** @test */
    public function itReturnsTheBlogFormattedWithTheCorrectKeys()
    {
        $blog = factory(Blog::class)->create();
        $tag = factory(BlogTag::class)->create();

        $blog->tags()->attach($tag);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$blog]));
        $item = $processor->process()->get('blogs')->get('items')->first();

        $this->assertArrayHasStructure(['title', 'link', 'description', 'image'], $item);
    }

    /** @test */
    public function itReturnsTheSubscribedBlogTags()
    {
        $blog = factory(Blog::class)->create();
        $tag = factory(BlogTag::class)->create();

        $blog->tags()->attach($tag);

        $processor = new DailyUpdatePreprocessor(new Collection([$tag]), new Collection([$blog]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itReturnsMultipleBlogs()
    {
        $firstBlog = factory(Blog::class)->create();
        $firstTag = factory(BlogTag::class)->create();

        $secondBlog = factory(Blog::class)->create();
        $secondTag = factory(BlogTag::class)->create();

        $firstBlog->tags()->attach($firstTag);
        $secondBlog->tags()->attach($secondTag);

        $processor = new DailyUpdatePreprocessor(new Collection(BlogTag::all()), new Collection(Blog::all()));
        $result = $processor->process();

        $this->assertCount(2, $result->get('blogs')->get('items'));
        $this->assertCount(2, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itWontIncludeDuplicateBlogs()
    {
        $blog = factory(Blog::class)->create();

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$blog, $blog]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('blogs')->get('items'));
    }

    /** @test */
    public function itWontIncludeDuplicateTags()
    {
        $firstBlog = factory(Blog::class)->create();
        $firstTag = factory(BlogTag::class)->create();

        $secondBlog = factory(Blog::class)->create();
        $secondTag = factory(BlogTag::class)->create();

        $firstBlog->tags()->attach($firstTag);
        $secondBlog->tags()->attach($firstTag);
        $secondBlog->tags()->attach($secondTag);

        $processor = new DailyUpdatePreprocessor(new Collection(BlogTag::all()), new Collection(Blog::all()));
        $result = $processor->process();

        $this->assertCount(2, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itWontIncludeTagsYourNotSubscribedTo()
    {
        $blog = factory(Blog::class)->create();
        $firstTag = factory(BlogTag::class)->create();
        $secondTag = factory(BlogTag::class)->create();

        $blog->tags()->attach($firstTag);
        $blog->tags()->attach($secondTag);

        $processor = new DailyUpdatePreprocessor(new Collection([$firstTag]), new Collection([$blog]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('blogs')->get('subscriptions'));
    }

    /** @test */
    public function itWillIncludeAnEatery()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);
        $eatery = $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$eatery]));
        $result = $processor->process();

        $this->assertTrue($result->get('eateries')->has('subscriptions'));
        $this->assertTrue($result->get('eateries')->has('items'));
        $this->assertCount(1, $result->get('eateries')->get('items'));
    }

    /** @test */
    public function itReturnsTheItemFormattedCorrectly()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);
        $eatery = $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$eatery]));
        $item = $processor->process()->get('eateries')->get('items')->first();

        $this->assertArrayHasStructure(['title', 'link', 'description', 'address'], $item);
    }

    /** @test */
    public function itReturnsTheSubscribedItems()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);
        $eatery = $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $processor = new DailyUpdatePreprocessor(new Collection([$county]), new Collection([$eatery]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('subscriptions'));
    }

    /** @test */
    public function itReturnsMultipleEateries()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);
        $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $country2 = factory(WhereToEatCountry::class)->create();
        $county2 = factory(WhereToEatCounty::class)->create(['country_id' => $country2->id]);
        $town2 = factory(WhereToEatTown::class)->create(['county_id' => $county2->id]);
        $eatery = $this->createWhereToEat(['town_id' => $town2->id, 'county_id' => $county2->id]);

        $blog = factory(Blog::class)->create();
        $tag = factory(BlogTag::class)->create();

        $blog->tags()->attach($tag);

        $processor = new DailyUpdatePreprocessor(new Collection([$county, $tag]), new Collection([$eatery, $blog]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('items'));
        $this->assertCount(1, $result->get('blogs')->get('items'));
    }

    /** @test */
    public function itWontIncludeDuplicateEateries()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);
        $eatery = $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $processor = new DailyUpdatePreprocessor(new Collection(), new Collection([$eatery, $eatery]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('items'));
    }

    /** @test */
    public function itWontIncludeDuplicateCounties()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);
        $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $processor = new DailyUpdatePreprocessor(new Collection([$county]), new Collection(WhereToEat::all()));
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('subscriptions'));
    }

    /** @test */
    public function itWillOnlyIncludeTheItemOnceIfYourSubscribedToBothCountyAndTown()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);
        $eatery = $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $processor = new DailyUpdatePreprocessor(new Collection([$county, $town]), new Collection([$eatery]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('items'));
        $this->assertCount(2, $result->get('eateries')->get('subscriptions'));
    }

    /** @test */
    public function itWillIncludeBothBlogsAndEateries()
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);
        $eatery = $this->createWhereToEat(['town_id' => $town->id, 'county_id' => $county->id]);

        $processor = new DailyUpdatePreprocessor(new Collection([$county, $town]), new Collection([$eatery]));
        $result = $processor->process();

        $this->assertCount(1, $result->get('eateries')->get('items'));
    }
}
