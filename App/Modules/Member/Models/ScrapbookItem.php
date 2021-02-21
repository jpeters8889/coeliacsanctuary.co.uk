<?php

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

class ScrapbookItem extends BaseModel
{
    public function item()
    {
        return $this->morphTo('item');
    }

    public function scrapbook()
    {
        return $this->belongsTo(Scrapbook::class);
    }
}
