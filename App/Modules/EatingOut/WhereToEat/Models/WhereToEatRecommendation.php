<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;

class WhereToEatRecommendation extends BaseModel
{
    protected $table = 'wheretoeat_place_recommendation';

    protected $casts = [
        'completed' => 'bool',
    ];

    public function venueType()
    {
        return $this->belongsTo(WhereToEatVenueType::class, 'place_venue_type_id');
    }
}
