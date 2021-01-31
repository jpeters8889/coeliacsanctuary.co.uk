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

    public function resolveItem($withs = [])
    {
        if ($parent = parent::resolveItem($withs)) {
            return $parent;
        }

        $legacy = $this->repository()
            ->setWiths($withs)
            ->get($this->route($this->identifier()), 'legacy_slug');

        if ($legacy) {
            redirect_now($legacy->link);
        }
    }
}
