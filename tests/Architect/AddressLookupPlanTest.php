<?php

declare(strict_types=1);

namespace Tests\Architect;

use Tests\Traits\CreatesWhereToEat;
use Illuminate\Foundation\Testing\WithFaker;
use Coeliac\Architect\Plans\AddressLookup\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JPeters\Architect\TestHelpers\Abstracts\PlanTestCase;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class AddressLookupPlanTest extends PlanTestCase
{
    use RefreshDatabase;
    use CreatesWhereToEat;
    use WithFaker;

    public function getPlan()
    {
        return Plan::class;
    }

    public function getColumnName()
    {
        return 'address';
    }

    /** @test */
    public function it_updates_the_model()
    {
        $eatery = new WhereToEat();

        $eatery->update([
            'address' => null,
            'lat' => null,
            'lng' => null,
        ]);

        $class = $this->getPlan();

        /** @var Plan $plan */
        $plan = new $class('address');

        $value = [
          'address' => 'Kings Cross Station, London',
          'lat' => 123,
          'lng' => 456,
        ];

        $plan->handleUpdate($eatery, 'email', json_encode($value));

        foreach ($value as $key => $val) {
            $this->assertEquals($val, $eatery->$key);
        }
    }
}
