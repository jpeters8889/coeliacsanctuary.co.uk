<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Members\Scrapbooks;

use Coeliac\Common\Models\Image;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Member\Models\Scrapbook;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Recipe\Models\Recipe;
use Tests\TestCase;
use Tests\Traits\HasImages;

class ScrapbookItemsTest extends TestCase
{
    use HasImages;

    protected User $user;
    protected Scrapbook $scrapbook;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = $this->build(User::class)
            ->asMember()
            ->create();

        $this->scrapbook = $this->build(Scrapbook::class)
            ->in($this->user)
            ->create();

        $this->actingAs($this->user);
    }

    protected function makeAddItemRequest($params = [], ?Scrapbook $scrapbook = null)
    {
        if (! $scrapbook) {
            $scrapbook = $this->scrapbook;
        }

        return $this->postJson("/api/member/dashboard/scrapbooks/{$scrapbook->id}", array_merge([
            'id' => 1,
            'type' => 'blog',
        ], $params));
    }

    /** @test */
    public function itErrorsWhenTryingToCreateAnItemWithoutAnId()
    {
        $this->makeAddItemRequest(['id' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToCreateAnItemWithoutAnType()
    {
        $this->makeAddItemRequest(['type' => null])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToCreateAnItemWithoutAnUnknownType()
    {
        $this->makeAddItemRequest(['type' => 'foo'])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToUseAnUnknownScrapbook()
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
    public function itAddsAnToTheItems($type, $class)
    {
        $this->assertCount(0, $this->scrapbook->items);

        $item = $this->create($class);

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
    public function itErrorsIfTheItemIsntLive($type, $class)
    {
        $this->assertCount(0, $this->scrapbook->items);

        $item = $this->create($class);

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
    public function itErrorsIfTheItemDoesntExist($type)
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
            ['blog', Blog::class],
            ['review', Review::class],
            ['recipe', Recipe::class],
        ];
    }

    /** @test */
    public function itErrorsWhenTryingToAddToAnotherUsersScrapbook()
    {
        $scrapbook = $this->create(Scrapbook::class);

        $this->makeAddItemRequest([], $scrapbook)->assertStatus(403);
    }

    /** @test */
    public function itErrorsWhenTryingToDeleteAnItemNotInTheScrapbook()
    {
        $this->create(Blog::class);

        $this->makeAddItemRequest();

        $this->assertCount(1, $this->scrapbook->fresh()->items);

        $this->delete("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}/2")->assertStatus(404);

        $this->assertCount(1, $this->scrapbook->fresh()->items);
    }

    /** @test */
    public function itCanDeleteAnItemFromAScrapbook()
    {
        $this->create(Blog::class);

        $this->makeAddItemRequest();

        $this->assertCount(1, $this->scrapbook->fresh()->items);

        $this->delete("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}/1")->assertOk();

        $this->assertCount(0, $this->scrapbook->fresh()->items);
    }

    /** @test */
    public function itErrorsWhenTryingToDeleteAnotherUsersItems()
    {
        $scrapbook = $this->create(Scrapbook::class);

        $this->create(Blog::class)->addToScrapbook($scrapbook);

        $this->assertCount(1, $scrapbook->fresh()->items);

        $this->delete("/api/member/dashboard/scrapbooks/{$scrapbook->id}/2")->assertStatus(404);

        $this->assertCount(1, $scrapbook->fresh()->items);
    }

    /** @test */
    public function itErrorsWhenTryingToSearchWithoutAType()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', ['id' => 1])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToSearchWithoutAnUnknownType()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', ['type' => 'foo', 'id' => 1])->assertStatus(422);
    }

    /** @test */
    public function itErrorsWhenTryingToSearchWithoutAnId()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', ['type' => 'blog'])->assertStatus(422);
    }

    /** @test */
    public function itCanSeeWhetherAnItemIsInTheScrapbook()
    {
        $blog = $this->create(Blog::class);

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
    public function itKnowsWhetherAnItemIsntInTheScrapbook()
    {
        $this->post('/api/member/dashboard/scrapbooks/search', [
            'area' => 'review',
            'id' => 1,
        ])->assertStatus(204);
    }

    /** @test */
    public function itLoadsTheItemsEndpoint()
    {
        $this->get("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")->assertOk();
    }

    /** @test */
    public function itReturnsAnArrayOfItems()
    {
        $request = $this->get("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}");

        $this->assertIsArray($request->json());
    }

    /** @test */
    public function itHasTheNeededDataInTheItemsEndpoint()
    {
        $blog = $this->create(Blog::class);
        $blog->addToScrapbook($this->scrapbook);

        $this->get("/api/member/dashboard/scrapbooks/{$this->scrapbook->id}")
            ->assertJsonStructure([['id', 'added', 'item' => ['area', 'title', 'description', 'image', 'link']]]);
    }

    /**
     * @test
     * @dataProvider scrapbookItemsDataProvider
     */
    public function itReturnsTheRequiredItemInformation($area, $class)
    {
        $item = $this->create($class);
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
            ['Blog', Blog::class],
            ['Recipe', Recipe::class],
            ['Review', Review::class],
        ];
    }

    /** @test */
    public function itErrorsWhenTryingToViewItemsInAScrapbookThatDoesntExist()
    {
        $this->get('/api/member/dashboard/scrapbooks/2')->assertStatus(404);
    }

    /** @test */
    public function itErrorsWhenTryingToViewAnotherUsersItems()
    {
        $scrapbook = $this->create(Scrapbook::class);

        $this->get("/api/member/dashboard/scrapbooks/{$scrapbook->id}")->assertStatus(403);
    }
}
