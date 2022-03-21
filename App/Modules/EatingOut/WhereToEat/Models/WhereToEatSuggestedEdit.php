<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\AddressField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\CuisineField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\FeaturesField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\GfMenuLinkField;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhereToEatSuggestedEdit extends BaseModel
{
    protected $table = 'wheretoeat_suggested_edits';

    public function eatery(): BelongsTo
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id');
    }

    public static function processorMaps(): array
    {
        return [
            'address' => AddressField::class,
            'cuisine' => CuisineField::class,
            'features' => FeaturesField::class,
            'gf_menu_link' => GfMenuLinkField::class,
            'opening_times' => '',
            'phone' => '',
            'venue_type' => '',
            'website' => '',
        ];
    }
}
