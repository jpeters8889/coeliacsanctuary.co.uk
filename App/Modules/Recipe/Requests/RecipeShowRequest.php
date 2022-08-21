<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Requests;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\Recipe\Repository;

class RecipeShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }

    public function resolveItem(array $withs = []): ?Recipe
    {
        if ($parent = parent::resolveItem($withs)) {
            /** @var Recipe $parent */
            return $parent;
        }

        /** @var ?Recipe $legacy */
        $legacy = $this->repository()
            ->setWiths($withs)
            ->get($this->route($this->identifier()), 'legacy_slug');

        if ($legacy instanceof Recipe) {
            redirect_now($legacy->link);
        }

        return null;
    }
}
