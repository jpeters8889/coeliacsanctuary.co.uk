<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Collections;

use Tests\TestCase;
use Tests\Traits\HasImages;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Collection\Models\Collection;

class CollectionsModelTest extends TestCase
{
    use HasImages;

    /** @test */
    public function itCreatesASlug()
    {
        $collection = $this->create(Collection::class, ['title' => 'Test Collection']);

        $this->assertNotNull($collection->slug);
        $this->assertEquals('test-collection', $collection->slug);
    }

    /** @test */
    public function itCanHaveAnImageAssociatedWithTheCollection()
    {
        /** @var Collection $collection */
        $collection = $this->create(Collection::class);

        $collection->associateImage($this->makeImage());

        $this->assertNotNull($collection->fresh()->first_image);
    }

    /** @test */
    public function itCanHaveItemsAddedToTheCollection()
    {
        /** @var Collection $collection */
        $collection = $this->create(Collection::class);

        $this->assertEmpty($collection->items);

        /** @var Blog $blog */
        $blog = $this->create(Blog::class);

        $collection->addItem($blog, $blog->meta_description)->refresh();

        $this->assertNotEmpty($collection->items);
    }
}
