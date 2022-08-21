<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;

/**
 * @extends BaseModel<TravelCardSearchTermHistory>
 *
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
