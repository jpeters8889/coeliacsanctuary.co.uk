<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;

class Accordion extends BaseModel
{
    protected $guarded = [];

    public function scopeCoeliacInfo(Builder $builder)
    {
        return $builder->where('accordion_type_id', AccordionType::COELIAC_INFO);
    }

    public function scopeFaq(Builder $builder)
    {
        return $builder->where('accordion_type_id', AccordionType::FAQ);
    }

    public function type()
    {
        return $this->belongsTo(AccordionType::class);
    }
}
