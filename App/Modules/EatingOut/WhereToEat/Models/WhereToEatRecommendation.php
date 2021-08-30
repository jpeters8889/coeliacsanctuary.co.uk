<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhereToEatRecommendation extends BaseModel
{
    protected $table = 'wheretoeat_place_recommendation';

    protected $casts = [
        'completed' => 'bool',
    ];

    public function venueType(): BelongsTo
    {
        return $this->belongsTo(WhereToEatVenueType::class, 'place_venue_type_id');
    }
}
