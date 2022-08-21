<?php

declare(strict_types=1);

namespace Tests\Unit\Modules\EatingOut\WhereToEat;

use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Tests\Abstracts\RepositoryTest;

class WhereToEatRepositoryTest extends RepositoryTest
{
    protected function factoryParameters(): array
    {
        return [];
    }

    protected function loadRepository(): AbstractRepository
    {
        return new Repository();
    }

    protected function model(): string
    {
        return WhereToEat::class;
    }
}
