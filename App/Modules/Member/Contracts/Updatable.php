<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Contracts;

use Coeliac\Base\Models\BaseModel;

/** @mixin BaseModel */
interface Updatable
{
    public function updatableName(): string;

    public function updatableLink(): string;
}
