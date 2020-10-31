<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;

class AccordionType extends BaseModel
{
    public const COELIAC_INFO = 1;
    public const FAQ = 2;

    public function accordions()
    {
        return $this->hasMany(Accordion::class);
    }
}
