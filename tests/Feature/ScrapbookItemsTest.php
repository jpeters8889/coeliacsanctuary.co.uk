<?php

declare(strict_types=1);

namespace Tests\Feature;

use Coeliac\Common\Models\Image;
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
use Tests\Traits\HasImages;

class ScrapbookItemsTest extends TestCase
{
    use CreatesBlogs;
    use CreatesReviews;
    use CreatesRecipes;
    use CreatesWhereToEat;
    use HasImages;
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

    protected function makeAddItemRequest($params = [], ?Scrapbook $scrapbook = null)
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
        $this->makeAddItemRequest(['id' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_create_an_item_without_an_type()
    {
        $this->makeAddItemRequest(['type' => null])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_create_an_item_without_an_unknown_type()
    {
        $this->makeAddItemRequest(['type' => 'foo'])->assertStatus(422);
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

        $this->makeAddItemRequest([
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

        $this->makeAddItemRequest([
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

        $this->makeAddItemRequest([
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

        $this->makeAddItemRequest([], $scrapbook)->assertStatus(403);
    }

    /** @test */
    public function it_errors_when_trying_to_delete_an_item_not_in_the_scrapbook()
    {
        $this->createBlog();

        $this->makeAddItemRequest();

        $this->assertCount(1, $this->scrapbook->fresh()->items);

        $this->delete("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}/2")->assertStatus(404);

        $this->assertCount(1, $this->scrapbook->fresh()->items);
    }

    /** @test */
    public function it_can_delete_an_item_from_a_scrapbook()
    {
        $this->createBlog();

        $this->makeAddItemRequest();

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

    /** @test */
    public function it_errors_when_trying_to_search_without_a_type()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', ['id' => 1])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_search_without_an_unknown_type()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', ['type' => 'foo', 'id' => 1])->assertStatus(422);
    }

    /** @test */
    public function it_errors_when_trying_to_search_without_an_id()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', ['type' => 'blog'])->assertStatus(422);
    }

    /** @test */
    public function it_can_see_whether_an_item_is_in_the_scrapbook()
    {
        $blog = $this->createBlog();
        $blog->addToScrapbook($this->scrapbook);

        $this->post('/api/member/dashboard/scrapbooks/search', [
            'area' => 'blog',
            'id' => $blog->id,
        ])->assertStatus(200)
            ->assertJson([
                'id' => 1,
                'scrapbook_id' => $this->scrapbook->id,
            ]);
    }

    /** @test */
    public function it_knows_whether_an_item_isnt_in_the_scrapbook()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', [
            'area' => 'review',
            'id' => 1,
        ])->assertStatus(204);
    }

    /** @test */
    public function it_loads_the_items_endpoint()
    {
        $this->get("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")->assertOk();
    }

    /** @test */
    public function it_returns_an_array_of_items()
    {
        $request = $this->get("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}");

        $this->assertIsArray($request->json());
    }

    /** @test */
    public function it_has_the_needed_data_in_the_items_endpoint()
    {
        $blog = $this->createBlog();
        $blog->addToScrapbook($this->scrapbook);

        $this->get("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")
            ->assertJsonStructure([['id', 'added', 'item' => ['area', 'title', 'description', 'image', 'link']]]);
    }

    /**
     * @test
     * @dataProvider scrapbookItemsDataProvider
     */
    public function it_returns_the_required_item_information($method, $area)
    {
        $item = $this->$method();
        $item->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER);
        $item->addToScrapbook($this->scrapbook);

        $request = $this->get("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}");

        $request->assertJsonFragment([
            'area' => $area,
            'title' => $item->title,
            'description' => $item->meta_description,
            'image' => $item->main_image,
            'link' => $item->link,
        ]);
    }

    public function scrapbookItemsDataProvider()
    {
        return [
            ['createBlog', 'Blog'],
            ['createRecipe', 'Recipe'],
            ['createReview', 'Review'],
        ];
    }

    /** @test */
    public function it_errors_when_trying_to_view_items_in_a_scrapbook_that_doesnt_exist()
    {
        $this->get('/api/member/dashboard/scrapbooks/2')->assertStatus(404);
    }

    /** @test */
    public function it_errors_when_trying_to_view_another_users_items()
    {
        $scrapbook = factory(Scrapbook::class)->create([
            'user_id' => factory(User::class)->create()->id,
            'name' => 'Another Scrapbook',
        ]);

        $this->get("/api/member/dashboard/scrapbooks/{$scrapbook->id}")->assertStatus(403);
    }
}
