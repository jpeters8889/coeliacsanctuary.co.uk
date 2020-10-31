<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property mixed $feature
 */
class WhereToEatFeature extends BaseModel
{
    protected $appends = ['image'];

    protected $table = 'wheretoeat_features';

    protected $visible = ['id', 'feature', 'icon', 'image'];

    public function eateries(): BelongsToMany
    {
        return $this->belongsToMany(WhereToEat::class, 'wheretoeat_assigned_features', 'feature_id', 'wheretoeat_id');
    }

    public function getImageAttribute()
    {
        return asset('assets/images/wte-features/'.$this->icon.'.png');
    }
}
