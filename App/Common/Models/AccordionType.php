<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AccordionType extends BaseModel
{
    public const COELIAC_INFO = 1;
    public const FAQ = 2;

    public function accordions(): HasMany
    {
        return $this->hasMany(Accordion::class);
    }
}
