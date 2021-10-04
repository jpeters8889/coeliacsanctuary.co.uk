<?php

namespace Database\Factories;

use Coeliac\Common\Models\Accordion;
use Coeliac\Common\Models\AccordionType;

class AccordionFactory extends Factory
{
    protected $model = Accordion::class;

    public function definition()
    {
        return [
            'accordion_type_id' => $this->faker->randomElement([1, 2]),
            'title' => $this->faker->name,
            'body' => $this->faker->paragraph,
        ];
    }

    public function info()
    {
        return $this->state(fn () => ['accordion_type_id' => AccordionType::COELIAC_INFO]);
    }
}
