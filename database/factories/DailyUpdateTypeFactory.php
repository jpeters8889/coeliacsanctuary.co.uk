<?php

namespace Database\Factories;

use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Member\Models\DailyUpdateType;

class DailyUpdateTypeFactory extends Factory
{
    protected $model = DailyUpdateType::class;

    public function definition()
    {
        return [
            'name' => 'Blog Tags',
            'description' => 'Blog Tags',
            'updatable_type' => BlogTag::class,
        ];
    }
}
