<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Models;

use Coeliac\Base\Models\BaseModel;

class SearchHistory extends BaseModel
{
    protected $casts = [
      'blogs' => 'bool',
      'recipes' => 'bool',
      'reviews' => 'bool',
      'eateries' => 'bool',
      'products' => 'bool',
    ];

    protected $table = 'search_history';
}
