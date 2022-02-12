<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\WteAttractions;

use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\Plan as ArchitectPlan;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\AttractionRestaurant;

class Plan extends ArchitectPlan
{
    public function vuePrefix(): string
    {
        return 'wte-attractions';
    }

    public function handleUpdate(Model $model, $column, $value, $index = null)
    {
        /* @var WhereToEat $model */
        $model->restaurants()->delete();

        foreach (json_decode($value) as $restaurant) {
            $model->restaurants()->create([
                'restaurant_name' => $restaurant->name,
                'info' => $restaurant->info,
            ]);
        }
    }

    public function getCurrentValue(Model $model)
    {
        /* @var WhereToEat $model */
        return $model->restaurants->transform(fn (AttractionRestaurant $restaurant) => [
            'name' => $restaurant->restaurant_name,
            'info' => $restaurant->info,
        ]);
    }
}
