<?php

namespace Tests\Unit;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\ScrapbookItem;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesBlogs;
use Tests\Traits\CreatesRecipes;
use Tests\Traits\CreatesReviews;
use Tests\Traits\CreatesWhereToEat;

class ScrapbookTest extends TestCase
{
    use CreatesBlogs;
    use CreatesRecipes;
    use CreatesReviews;
    use CreatesWhereToEat;
    use RefreshDatabase;

    protected Scrapbook $scrapbook;

    protected function setUp(): void
    {
        parent::setUp();

        $user = factory(User::class)->create();
        $this->scrapbook = factory(Scrapbook::class)->create(['user_id' => $user->id]);
    }

    /** @test */
    public function it_belongs_to_a_user()
    {
        $this->assertNotNull($this->scrapbook->user);
        $this->assertInstanceOf(User::class, $this->scrapbook->user);
    }

    /** @test */
    public function it_can_have_items()
    {
        $this->assertCount(0, $this->scrapbook->refresh()->items);

        $blog = $this->createBlog();

        ScrapbookItem::query()->create([
            'scrapbook_id' => $this->scrapbook->id,
            'item_id' => $blog->id,
            'item_type' => $blog,
        ]);

        $this->assertCount(1, $this->scrapbook->refresh()->items);
    }

    /** @test */
    public function it_can_access_the_individual_item()
    {
        $blog = $this->createBlog();

        ScrapbookItem::query()->create([
            'scrapbook_id' => $this->scrapbook->id,
            'item_id' => $blog->id,
            'item_type' => get_class($blog),
        ]);

        $this->assertInstanceOf(Blog::class, $this->scrapbook->fresh()->items[0]->item);
    }

    /**
     * @test
     * @dataProvider itemDataProvider
     */
    public function it_can_have_items_added($createMethod, $expectedClass)
    {
        /** @var BaseModel $item */
        $item = $this->$createMethod();

        ScrapbookItem::query()->create([
            'scrapbook_id' => $this->scrapbook->id,
            'item_id' => $item->id,
            'item_type' => get_class($item),
        ]);

        $this->scrapbook->refresh();

        $this->assertCount(1, $this->scrapbook->items);
        $this->assertInstanceOf($expectedClass, $relation = $this->scrapbook->items[0]->item);
        $this->assertTrue($item->is($relation));
    }

    /**
     * @test
     * @dataProvider itemDataProvider
     */
    public function it_can_have_items_added_via_a_helper_method($createMethod, $expectedClass)
    {
        /** @var BaseModel $item */
        $item = $this->$createMethod();

        $item->addToScrapbook($this->scrapbook);

        $this->scrapbook->refresh();

        $this->assertCount(1, $this->scrapbook->items);$this->assertInstanceOf($expectedClass, $relation = $this->scrapbook->items[0]->item);
        $this->assertTrue($item->is($relation));
    }

    public function itemDataProvider(): array
    {
        return [
            ['createBlog', Blog::class],
            ['createRecipe', Recipe::class],
            ['createReview', Review::class],
        ];
    }
}
