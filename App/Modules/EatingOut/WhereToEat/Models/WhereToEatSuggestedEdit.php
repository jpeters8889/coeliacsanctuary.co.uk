<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\AddressField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\CuisineField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\FeaturesField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\GfMenuLinkField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\InfoField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\OpeningTimesField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\PhoneField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\VenueTypeField;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\Processors\WebsiteField;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property WhereToEat $eatery
 * @property int $id
 * @property string status
 * @property string $field
 * @property string $value
 * @property bool $accepted
 * @property bool $rejected
 */
class WhereToEatSuggestedEdit extends BaseModel
{
    protected $table = 'wheretoeat_suggested_edits';

    protected $casts = [
        'accepted' => 'bool',
        'rejected' => 'bool',
    ];

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
            'opening_times' => OpeningTimesField::class,
            'phone' => PhoneField::class,
            'venue_type' => VenueTypeField::class,
            'website' => WebsiteField::class,
            'info' => InfoField::class,
        ];
    }

    public function getStatusAttribute(): string
    {
        if ($this->accepted) {
            return 'Accepted';
        }

        if ($this->rejected) {
            return 'Rejected';
        }

        return 'New';
    }
}
