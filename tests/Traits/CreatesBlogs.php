<?php

declare(strict_types=1);

namespace Tests\Traits;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;

trait CreatesBlogs
{
    protected function createBlog($params = []): Blog
    {
        return factory(Blog::class)->create($params);
    }

    protected function createBlogTag($params = []): BlogTag
    {
        return factory(BlogTag::class)->create($params);
    }
}
