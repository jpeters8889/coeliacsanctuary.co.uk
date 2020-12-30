<?php

namespace Tests\Unit;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Collection\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Tests\Traits\CreatesBlogs;
use Tests\Traits\HasImages;

class CollectionsModelTest extends TestCase
{
    use RefreshDatabase;
    use HasImages;
    use CreatesBlogs;

    /** @test */
    public function it_creates_a_slug()
    {
        $collection = factory(Collection::class)->create(['title' => 'Test Collection']);

        $this->assertNotNull($collection->slug);
        $this->assertEquals('test-collection', $collection->slug);
    }

    /** @test */
    public function it_can_have_an_image_associated_with_the_collection()
    {
        /** @var Collection $collection */
        $collection = factory(Collection::class)->create();

        $collection->associateImage($this->makeImage());

        $this->assertNotNull($collection->fresh()->first_image);
    }

    /** @test */
    public function it_can_have_items_added_to_the_collection()
    {
        /** @var Collection $collection */
        $collection = factory(Collection::class)->create();

        $this->assertEmpty($collection->items);

        /** @var Blog $blog */
        $blog = $this->createBlog();

        $collection->addItem($blog, $blog->meta_description)->refresh();

        $this->assertNotEmpty($collection->items);
    }
}
