<?php

declare(strict_types=1);

namespace Coeliac\Modules\Collection\Requests;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Collection\Models\Collection;
use Coeliac\Modules\Collection\Repository;

/**
 * @extends ModuleRequest<Collection>
 */
class CollectionShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }

    public function resolveItem(array $withs = []): ?Collection
    {
        return parent::resolveItem($withs);
    }
}
