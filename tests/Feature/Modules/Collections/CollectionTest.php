<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Collections;

use Carbon\Carbon;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Common\Models\Image;
use Tests\Traits\CreatesRecipes;
use Tests\Traits\CreatesReviews;
use Tests\Traits\CreatesWhereToEat;
use Tests\Traits\Shop\CreateProduct;
use Coeliac\Modules\Collection\Items\Item;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Collection\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionTest extends TestCase
{
    use RefreshDatabase;
    use CreatesBlogs;
    use CreatesRecipes;
    use CreatesWhereToEat;
    use CreatesReviews;
    use CreateProduct;
    use HasImages;

    /** @test */
    public function itLoadsTheCollectionIndexPage()
    {
        $this->get('/collection')
            ->assertStatus(200)
            ->assertSee('<module-list-index module="collection" title="Collections" url-prefix="collection" :show-filter-bar="false">', false);
    }

    /** @test */
    public function itLoadsTheBlogApiEndpoint()
    {
        $max = [];

        for ($collectionX = 0; $collectionX < 13; ++$collectionX) {
            /** @var Collection $collection */
            $collection = factory(Collection::class)->create([
                'title' => 'collection-'.$collectionX,
                'created_at' => Carbon::now()->subDays($collectionX),
            ]);

            for ($x = 0; $x <= $collectionX; ++$x) {
                $collection->addItem($this->createBlog(), 'foobar');
            }
        }

        $request = $this->get('/api/collection');

        $request->assertJsonStructure([
            'data' => [
                'current_page',
                'data',
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total',
            ],
        ]);

        for ($collectionX = 0; $collectionX < 12; ++$collectionX) {
            $request->assertSee('collection-'.$collectionX, false);
            $request->assertJsonFragment(['items_count' => (string) ($collectionX + 1)]);
        }

        $request->assertDontSee('collection-12');
    }

    /** @test */
    public function itShowsCollectionPage()
    {
        /** @var Collection $collection */
        $collection = factory(Collection::class)->create();

        $collection->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->get('/collection/'.$collection->slug)
            ->assertStatus(200)
            ->assertSee($collection->title, false)
            ->assertSee($collection->body, false)
            ->assertSee($collection->main_image, false)
            ->assertSee($collection->social_image, false);
    }

    /** @test */
    public function itShowsCollectionItems()
    {
        /** @var Collection $collection */
        $collection = factory(Collection::class)->create();

        $collection->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $collection->addItem($this->createBlog(['title' => 'Test Blog']), 'Test Description');

        $this->get('/collection/'.$collection->slug)
            ->assertSee('Test Blog')
            ->assertSee('Test Description');
    }

    /**
     * @test
     * @dataProvider itemDataProvider
     */
    public function itShowsARenderedItems($method)
    {
        /** @var Collection $collection */
        $collection = factory(Collection::class)->create();

        $collection->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $collection->addItem($this->$method(), 'foobar');

        if ($method === 'createProduct') {
            ShopProduct::query()->first()->prices()->create(['price' => 1000]);
        }

        $renderedContent = Item::resolve($collection->items[0])->render();

        $this->get('/collection/'.$collection->slug)
            ->assertSee($renderedContent, false);
    }

    public function itemDataProvider()
    {
        return [
            ['createBlog'],
            ['createRecipe'],
            ['createReview'],
            ['createWhereToEat'],
            ['createProduct'],
        ];
    }
}
