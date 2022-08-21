<?php

declare(strict_types=1);

namespace Coeliac\Common\Models;

use Coeliac\Base\Models\BaseModel;

/** @extends BaseModel<Announcement> */
class Announcement extends BaseModel
{
    protected $dates = ['expires_at'];
}
