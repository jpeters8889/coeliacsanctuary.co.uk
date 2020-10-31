<?php

declare(strict_types=1);

namespace Coeliac\Base;

use Illuminate\Foundation\Application as IlluminateApplication;

class Application extends IlluminateApplication
{
    protected $appPath = __DIR__.'/../';

    protected $namespace = 'Coeliac';
}
