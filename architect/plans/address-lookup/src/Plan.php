<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\AddressLookup;

use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public function vuePrefix(): string
    {
        return 'address-lookup';
    }

    public function handleUpdate(Model $model, $column, $value)
    {
        $value = json_decode($value, true);

        $model->address = cs_nl2br($value['address']);
        $model->lat = $value['lat'];
        $model->lng = $value['lng'];
    }

    public function getCurrentValue(Model $model)
    {
        return [
            'address' => cs_br2nl($model->address),
            'lat' => $model->lat,
            'lng' => $model->lng,
        ];
    }
}
