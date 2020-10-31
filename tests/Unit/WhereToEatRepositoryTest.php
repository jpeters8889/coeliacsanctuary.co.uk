<?php

declare(strict_types=1);

namespace Tests\Unit;

use Tests\Abstracts\RepositoryTest;
use Coeliac\Common\Repositories\AbstractRepository;
use Coeliac\Modules\EatingOut\WhereToEat\Repository;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;

class WhereToEatRepositoryTest extends RepositoryTest
{
    protected function factoryParameters(): array
    {
        $country = factory(WhereToEatCountry::class)->create();
        $county = factory(WhereToEatCounty::class)->create(['country_id' => $country->id]);
        $town = factory(WhereToEatTown::class)->create(['county_id' => $county->id]);

        return [
            'town_id' => $town->id,
            'county_id' => $county->id,
            'country_id' => $country->id,
        ];
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
