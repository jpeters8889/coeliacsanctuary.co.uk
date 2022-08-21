<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Requests;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Common\Requests\ModuleRequest;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\Reviews\Repository;

class ReviewShowRequest extends ModuleRequest
{
    protected function repository(): AbstractRepository
    {
        return new Repository();
    }

    public function resolveItem(array $withs = []): ?Review
    {
        if ($parent = parent::resolveItem($withs)) {
            /** @var Review $parent */
            return $parent;
        }

        /** @var Review | null $legacy */
        $legacy = $this->repository()
            ->setWiths($withs)
            ->get($this->route($this->identifier()), 'legacy_slug');

        if ($legacy instanceof Review) {
            redirect_now($legacy->link);
        }

        return null;
    }
}
