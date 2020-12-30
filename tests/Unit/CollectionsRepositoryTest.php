<?php

namespace Tests\Unit;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\Collection\Models\Collection;
use Coeliac\Modules\Collection\Repository;
use Tests\Abstracts\RepositoryTest;

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
