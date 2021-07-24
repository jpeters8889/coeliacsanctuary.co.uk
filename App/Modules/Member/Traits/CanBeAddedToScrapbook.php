<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Traits;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Models\Scrapbook;

/** @mixin BaseModel */
trait CanBeAddedToScrapbook
{
    public function addToScrapbook(Scrapbook $scrapbook)
    {
        $scrapbook->items()->create([
            'item_id' => $this->getKey(),
            'item_type' => static::class,
        ]);
    }
}
