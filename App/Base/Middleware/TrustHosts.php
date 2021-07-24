<?php

declare(strict_types=1);

namespace Coeliac\Base\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

class TrustHosts extends Middleware
{
    public function hosts()
    {
        return [
            'coeliac.test',
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
