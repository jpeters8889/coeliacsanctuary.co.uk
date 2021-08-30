<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Requests;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Repository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Common\Repositories\AbstractRepository;

class BlogShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }

    public function resolveItem(array $withs = []): ?Blog
    {
        /** @phpstan-ignore-next-line  */
        return parent::resolveItem($withs);
    }
}
