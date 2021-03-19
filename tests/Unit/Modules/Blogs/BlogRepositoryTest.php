<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Blogs;

use Carbon\Carbon;
use Tests\Traits\HasImages;
use Coeliac\Common\Models\Image;
use Tests\Abstracts\RepositoryTest;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Common\Repositories\AbstractRepository;

class BlogRepositoryTest extends RepositoryTest
{
    use HasImages;

    protected function loadRepository(): AbstractRepository
    {
        return new Repository();
    }

    protected function model(): string
    {
        return Blog::class;
    }

    /** @test */
    public function itIsOrderedByNewestFirst()
    {
        $latest = $this->models[count($this->models) - 1];
        $latest->created_at = Carbon::now()->addMinutes(5);
        $latest->save();

        $this->assertTrue(
            $latest->is($this->repository->all()->first())
        );
    }

    /** @test */
    public function itHasTheImagesIncluded()
    {
        $this->models[0]->associateImage($this->makeImage(), Image::IMAGE_CATEGORY_HEADER);

        $this->assertNotNull($this->repository->get(1)->images);
        $this->assertNotNull($this->repository->get(1)->main_image);
    }

    /** @test */
    public function itHasTheTagsIncluded()
    {
        $this->models[0]->tags()->attach(factory(BlogTag::class)->create());

        $this->assertNotNull($this->repository->get(1)->tags);
    }
}
