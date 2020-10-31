<?php

declare(strict_types=1);

namespace Coeliac\Common\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasComments
{
    public function comments(): MorphMany;

    public function allComments(): MorphMany;
}
