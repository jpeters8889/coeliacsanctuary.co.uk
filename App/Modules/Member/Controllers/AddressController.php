<?php

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Illuminate\Contracts\Auth\Authenticatable;

class AddressController extends BaseController
{
    public function list(Authenticatable $user)
    {
        return $user->addresses->sortByDesc('updated_at')->values();
    }
}
