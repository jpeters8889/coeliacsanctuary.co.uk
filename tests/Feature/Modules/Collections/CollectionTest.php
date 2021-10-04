<?php

declare(strict_types=1);

namespace Tests\Feature\Modules\Collections;

use Carbon\Carbon;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\Recipe\Models\Recipe;
use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Coeliac\Modules\Collection\Items\Item;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Collection\Models\Collection;

class CollectionTest extends TestCase
{
    use HasImages;

    /** @test */
    public function itLoadsTheCollectionIndexPage()
    {
        $this->get('/collection')
            ->assertStatus(200)
            ->assertSee('<module-list-index module="collection" title="Collections" url-prefix="collection" :show-filter-bar="false"', false);
    }

    /** @test */
    public function itLoadsTheCollectionsApiEndpoint()
    {
        $this->build(Collection::class)
            ->count(13)
            ->sequence(fn ($sequence) => [
                'title' => "Collection {$sequence->index}",
                'created_at' => Carbon::now()->subMonth()->addDay($sequence->index)
            ])
            ->create()
            ->each(function (Collection $collection, $index) {
                for ($x = 0; $x <= $index; $x++) {
                    $collection->addItem($this->create(Blog::class), 'foobar');
                }
            });

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
            $request->assertSee('collection-' . $collectionX, false);
            $request->assertJsonFragment(['items_count' => (string)($collectionX + 1)]);
        }

        $request->assertDontSee('collection-12');
    }

    /** @test */
    public function itShowsCollectionPage()
    {
        $collection = $this->create(Collection::class)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL);

        $this->get('/collection/' . $collection->slug)
            ->assertStatus(200)
            ->assertSee($collection->title, false)
            ->assertSee($collection->body, false)
            ->assertSee($collection->main_image, false)
            ->assertSee($collection->social_image, false);
    }

    /** @test */
    public function itShowsCollectionItems()
    {
        $collection = $this->create(Collection::class)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL)
            ->addItem($this->create(Blog::class, ['title' => 'Test Blog']), 'Test Description');

        $this->get('/collection/' . $collection->slug)
            ->assertSee('Test Blog')
            ->assertSee('Test Description');
    }

    /**
     * @test
     * @dataProvider itemDataProvider
     */
    public function itShowsARenderedItems($class)
    {
        $collection = $this->create(Collection::class)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER)
            ->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_SOCIAL)
            ->addItem($this->create($class), 'Test Description');

        $renderedContent = Item::resolve($collection->items[0])->render();

        $this->get('/collection/' . $collection->slug)
            ->assertSee($renderedContent, false);
    }

    public function itemDataProvider()
    {
        return [
            [Blog::class],
            [Recipe::class],
            [Review::class],
            [WhereToEat::class],
            [ShopProduct::class],
        ];
    }
}
