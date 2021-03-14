<?php

namespace Coeliac\Architect\Plans\CompetitionEntries;

use Illuminate\Database\Eloquent\Model;
use JPeters\Architect\Plans\Plan as ArchitectPlan;

class Plan extends ArchitectPlan
{
    public function vuePrefix(): string
    {
        return 'competition-entries';
    }

    public function handleUpdate(Model $model, $column, $value)
    {
        $model->$column = $value;
    }
}
