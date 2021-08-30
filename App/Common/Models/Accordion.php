<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Accordion extends BaseModel
{
    protected $guarded = [];

    public function scopeCoeliacInfo(Builder $builder): Builder
    {
        return $builder->where('accordion_type_id', AccordionType::COELIAC_INFO);
    }

    public function scopeFaq(Builder $builder): Builder
    {
        return $builder->where('accordion_type_id', AccordionType::FAQ);
    }

    public function type(): BelongsTo
    {
        return $this->belongsTo(AccordionType::class);
    }
}
