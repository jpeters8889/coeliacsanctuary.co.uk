<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @extends BaseModel<RecipeMeal>
 *
 * @property int $id
 * @property string $meal
 */
class RecipeMeal extends BaseModel
{
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_meals', 'recipe_id', 'meal_type_id');
    }
}
