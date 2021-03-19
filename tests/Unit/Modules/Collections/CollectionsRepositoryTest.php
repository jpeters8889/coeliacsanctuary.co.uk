<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\Collections;

use Tests\Abstracts\RepositoryTest;
use Coeliac\Modules\Collection\Repository;
use Coeliac\Modules\Collection\Models\Collection;
use Coeliac\Common\Repositories\AbstractRepository;

class CollectionsRepositoryTest extends RepositoryTest
{
    protected function loadRepository(): AbstractRepository
    {
        return new Repository();
    }

    protected function model(): string
    {
        return Collection::class;
    }
}
