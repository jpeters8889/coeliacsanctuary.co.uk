<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Requests;

use Coeliac\Modules\Recipe\Repository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Common\Repositories\AbstractRepository;

class RecipeShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }
}
