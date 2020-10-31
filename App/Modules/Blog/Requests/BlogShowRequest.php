<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Requests;

use Coeliac\Modules\Blog\Repository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Common\Repositories\AbstractRepository;

class BlogShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }
}
