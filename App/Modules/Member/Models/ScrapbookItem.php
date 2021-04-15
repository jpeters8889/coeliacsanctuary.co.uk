<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Models;

use Coeliac\Base\Models\BaseModel;

/**
 * @property BaseModel item
 */
class ScrapbookItem extends BaseModel
{
    protected $casts = [
      'scrapbook_id' => 'int',
    ];

    public function item()
    {
        return $this->morphTo('item');
    }

    public function scrapbook()
    {
        return $this->belongsTo(Scrapbook::class);
    }
}
