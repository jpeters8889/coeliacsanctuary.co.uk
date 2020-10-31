<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;

class Announcement extends BaseModel
{
    protected $dates = ['expires_at'];
}
