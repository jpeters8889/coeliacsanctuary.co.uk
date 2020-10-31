<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\OrderDispatchSlip;

use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public function vuePrefix(): string
    {
        return 'order-dispatch-slip';
    }

    public function handleUpdate(Model $model, $column, $value)
    {
        //
    }
}
