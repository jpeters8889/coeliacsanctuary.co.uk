<?php

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @property int $id
 * @property string $term
 * @property int $hits
 */
class TravelCardSearchTermHistory extends BaseModel
{
    protected $table = 'shop_product_travel_card_search_history';

    protected $casts = [
        'hits' => 'int',
    ];
}
