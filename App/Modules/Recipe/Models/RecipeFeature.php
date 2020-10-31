<?php

declare(strict_types=1);

namespace Coeliac\Modules\Recipe\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RecipeFeature extends BaseModel
{
    protected $appends = ['image'];

    protected $visible = [
        'id',
        'feature',
        'image',
    ];

    public function getImageAttribute()
    {
        return asset('assets/images/recipe-features/'.$this->icon.'.png');
    }

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'recipe_assigned_features', 'recipe_id', 'feature_type_id');
    }
}
