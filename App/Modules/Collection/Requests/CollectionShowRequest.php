<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Requests;

use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Collection\Repository;
use Coeliac\Common\Repositories\AbstractRepository;

class CollectionShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }
}
