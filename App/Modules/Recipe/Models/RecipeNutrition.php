<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $calories
 * @property mixed  $carbs
 * @property mixed  $fat
 * @property mixed  $protein
 * @property mixed  $sugar
 * @property mixed  $fibre
 */
class RecipeNutrition extends BaseModel
{
    protected $hidden = ['id', 'created_at', 'updated_at'];

    public function recipe(): BelongsTo
    {
        return $this->belongsTo(Recipe::class);
    }
}
