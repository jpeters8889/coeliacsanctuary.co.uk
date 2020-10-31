<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Models;

use Coeliac\Base\Models\BaseModel;

class RecipeMeal extends BaseModel
{
    public function recipes()
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_meals', 'recipe_id', 'meal_type_id');
    }
}
