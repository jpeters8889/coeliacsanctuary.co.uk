<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @extends BaseModel<WhereToEatPlaceReport> */
class WhereToEatPlaceReport extends BaseModel
{
    protected $table = 'wheretoeat_place_reports';

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id');
    }
}
