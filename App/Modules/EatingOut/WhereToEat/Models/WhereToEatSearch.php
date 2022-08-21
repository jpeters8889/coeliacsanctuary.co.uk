<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/** @extends BaseModel<WhereToEatSearch> */
class WhereToEatSearch extends BaseModel
{
    protected $table = 'wheretoeat_searches';

    public function term(): BelongsTo
    {
        return $this->belongsTo(WhereToEatSearchTerm::class, 'search_term_id');
    }
}
