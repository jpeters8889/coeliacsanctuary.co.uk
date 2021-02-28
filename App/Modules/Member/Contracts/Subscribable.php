<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Contracts;

use Coeliac\Base\Models\BaseModel;

/** @mixin BaseModel */
interface Subscribable
{
    public function subscribableName(): string;

    public function subscribableLink(): string;
}
