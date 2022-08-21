<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Requests;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Repository;

/** @extends ModuleRequest<Blog> */
class BlogShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }

    public function resolveItem(array $withs = []): ?Blog
    {
        return parent::resolveItem($withs);
    }
}
