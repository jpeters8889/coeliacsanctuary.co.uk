<?php

namespace Coeliac\Modules\EatingOut\WhereToEat\Models;

use Coeliac\Base\Models\BaseModel;

class WhereToEatPlaceReport extends BaseModel
{
    protected $table = 'wheretoeat_place_reports';

    public function eatery()
    {
        return $this->belongsTo(WhereToEat::class, 'wheretoeat_id');
    }
}
