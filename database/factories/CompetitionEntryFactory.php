<?php

namespace Database\Factories;

use Coeliac\Modules\Competition\Models\Competition;
use Coeliac\Modules\Competition\Models\CompetitionEntry;

class CompetitionEntryFactory extends Factory
{
    protected $model = CompetitionEntry::class;

    public function definition()
    {
        return [
            'competition_id' => self::factoryForModel(Competition::class),
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'entry_type' => 'facebook',
        ];
    }
}
