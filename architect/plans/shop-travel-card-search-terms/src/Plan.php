<?php

namespace Coeliac\Architect\Plans\ShopTravelCardSearchTerms;

use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\TravelCardSearchTerm;
use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public bool $deferUpdate = true;

    public function vuePrefix(): string
    {
        return 'shop-travel-card-search-terms';
    }

    public function hasDatabaseColumn(): bool
    {
        return false;
    }

    public function getCurrentValue(Model $model)
    {
        $model->load(['products', 'products.prices', 'products.images']);

        return parent::getCurrentValue($model);
    }

    public function handleUpdate(Model $model, $column, $value)
    {
        /** @var TravelCardSearchTerm $model */

        $model->products()->detach();

        collect(json_decode($value))
            ->each(fn ($id) => $model->products()->attach(ShopProduct::query()->findOrFail($id)));
    }
}
