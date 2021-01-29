<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Models;

use Coeliac\Base\Models\BaseModel;

class SearchHistory extends BaseModel
{
    protected $casts = [
        'number_of_searches' => 'int',
    ];

    protected $table = 'search_history';
}
