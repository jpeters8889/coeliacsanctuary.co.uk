<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Requests;

use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\EatingOut\Reviews\Repository;
use Coeliac\Common\Repositories\AbstractRepository;

class ReviewShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }

    public function resolveItem($withs = [])
    {
        if ($parent = parent::resolveItem($withs)) {
            return $parent;
        }

        return $this->repository()
            ->setWiths($withs)
            ->get($this->route($this->identifier()), 'legacy_slug');
    }
}
