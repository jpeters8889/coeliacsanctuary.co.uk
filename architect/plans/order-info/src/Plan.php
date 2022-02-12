<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\OrderInfo;

use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public function vuePrefix(): string
    {
        return 'order-info';
    }

    public function handleUpdate(Model $model, $column, $value, $index = null)
    {
        //
    }
}
