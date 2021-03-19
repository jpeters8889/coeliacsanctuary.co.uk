<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Collections;

use Tests\TestCase;
use Tests\Traits\HasImages;
use Tests\Traits\CreatesBlogs;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Collection\Models\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CollectionsModelTest extends TestCase
{
    use RefreshDatabase;
    use HasImages;
    use CreatesBlogs;

    /** @test */
    public function itCreatesASlug()
    {
        $collection = factory(Collection::class)->create(['title' => 'Test Collection']);

        $this->assertNotNull($collection->slug);
        $this->assertEquals('test-collection', $collection->slug);
    }

    /** @test */
    public function itCanHaveAnImageAssociatedWithTheCollection()
    {
        /** @var Collection $collection */
        $collection = factory(Collection::class)->create();

        $collection->associateImage($this->makeImage());

        $this->assertNotNull($collection->fresh()->first_image);
    }

    /** @test */
    public function itCanHaveItemsAddedToTheCollection()
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
