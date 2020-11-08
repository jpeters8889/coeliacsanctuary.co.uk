<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;

class TokenController extends BaseController
{
    public function get()
    {
        return [
            'token' => csrf_token(),
        ];
    }
}
