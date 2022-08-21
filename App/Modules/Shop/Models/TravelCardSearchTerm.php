<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @extends BaseModel<TravelCardSearchTerm>
 *
 * @property int $id
 * @property string $term
 * @property Collection<ShopProduct> $products
 * @property string $type
 */
class TravelCardSearchTerm extends BaseModel
{
    protected $table = 'shop_product_travel_cards_search_terms';

//    protected $visible = ['id', 'term', 'type'];

    protected $casts = [
        'hits' => 'int',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(
            ShopProduct::class,
            'shop_product_assigned_travel_card_search_terms',
            'search_term_id',
            'product_id',
        );
    }
}
