<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @extends BaseModel<RecipeAllergen>
 *
 * @property string $id
 * @property string $allergen
 */
class RecipeAllergen extends BaseModel
{
    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_allergens', 'recipe_id', 'allergen_type_id');
    }
}
