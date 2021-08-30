<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhereToEatSearch extends Model
{
    protected $guarded = [];

    protected $table = 'wheretoeat_searches';

    public function term(): BelongsTo
    {
        return $this->belongsTo(WhereToEatSearchTerm::class, 'search_term_id');
    }
}
