<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Recipe\Models\Recipe;
use Tests\TestCase;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\UserLevel;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Traits\CreatesBlogs;
use Tests\Traits\CreatesRecipes;
use Tests\Traits\CreatesReviews;
use Tests\Traits\CreatesWhereToEat;

class ScrapbookItemsTest extends TestCase
{
    use CreatesBlogs;
    use CreatesReviews;
    use CreatesRecipes;
    use CreatesWhereToEat;
    use RefreshDatabase;

    protected User $user;
    protected Scrapbook $scrapbook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['user_level_id' => UserLevel::MEMBER]);
        $this->scrapbook = factory(Scrapbook::class)->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user);
    }

    protected function makeRequest($params = [], ?Scrapbook $scrapbook = null)
    {
        if (!$scrapbook) {
            $scrapbook = $this->scrapbook;
        }

        return $this->postJson("/api/member/dashboard/scrapbooks/{$scrapbook->id}", array_merge([
            'id' => 1,
            'type' => 'blog',
        ], $params));
    }

    /** @test */
    public function it_errors_when_trying_to_create_an_item_without_an_id()
    {
        $this->makeRequest(['id' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_create_an_item_without_an_type()
    {
        $this->makeRequest(['type' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_create_an_item_without_an_unknown_type()
    {
        $this->makeRequest(['type' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_use_an_unknown_scrapbook()
    {
        $this->postJson('/api/member/dashboard/scrapbooks/2', [
            'id' => 1,
            'type' => 'blog',
        ])->assertStatus(404);
    }

    /**
     * @test
     * @dataProvider itemsDataProvider
     */
    public function it_adds_an_to_the_items($method, $type, $class)
    {
        $this->assertCount(0, $this->scrapbook->items);

        $item = $this->$method();

        $this->makeRequest([
            'id' => $item->id,
            'type' => $type,
        ]);

        $this->assertCount(1, $this->scrapbook->refresh()->items);
        $this->assertInstanceOf($class, $this->scrapbook->items[0]->item);
    }

    /**
     * @test
     * @dataProvider itemsDataProvider
     */
    public function it_errors_if_the_item_isnt_live($method, $type)
    {
        $this->assertCount(0, $this->scrapbook->items);

        $item = $this->$method();

        $item->update(['live' => 0]);

        $this->makeRequest([
            'id' => $item->id,
            'type' => $type,
        ]);

        $this->assertCount(0, $this->scrapbook->refresh()->items);
    }

    /**
     * @test
     * @dataProvider itemsDataProvider
     */
    public function it_errors_if_the_item_doesnt_exist($method, $type)
    {
        $this->assertCount(0, $this->scrapbook->items);

        $this->makeRequest([
            'id' => 1,
            'type' => $type,
        ])->assertStatus(404);

        $this->assertCount(0, $this->scrapbook->refresh()->items);
    }

    public function itemsDataProvider()
    {
        return [
            ['createBlog', 'blog', Blog::class],
            ['createReview', 'review', Review::class],
            ['createRecipe', 'recipe', Recipe::class],
        ];
    }

    /** @test */
    public function it_errors_when_trying_to_add_to_another_users_scrapbook()
    {
        $scrapbook = factory(Scrapbook::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'name' => 'Another Scrapbook',
        ]);

        $this->createBlog();

        $this->makeRequest([], $scrapbook)->assertStatus(403);
    }

    /** @test */
    public function it_errors_when_trying_to_delete_an_item_not_in_the_scrapbook()
    {
        $this->createBlog();

        $this->makeRequest();

        $this->assertCount(1, $this->scrapbook->fresh()->items);

        $this->delete("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}/2")->assertStatus(404);

        $this->assertCount(1, $this->scrapbook->fresh()->items);
    }

    /** @test */
    public function it_can_delete_an_item_from_a_scrapbook()
    {
        $this->createBlog();

        $this->makeRequest();

        $this->assertCount(1, $this->scrapbook->fresh()->items);

        $this->delete("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}/1")->assertOk();

        $this->assertCount(0, $this->scrapbook->fresh()->items);
    }

    /** @test */
    public function it_errors_when_trying_to_delete_another_users_items()
    {
        $scrapbook = factory(Scrapbook::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'name' => 'Another Scrapbook',
        ]);

        $blog = $this->createBlog();
        $blog->addToScrapbook($scrapbook);

        $this->assertCount(1, $scrapbook->fresh()->items);

        $this->delete("/api/member/dashboard/scrapbooks/{$scrapbook->id}/2")->assertStatus(404);

        $this->assertCount(1, $scrapbook->fresh()->items);
    }
}
