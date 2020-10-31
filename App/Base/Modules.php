<?php

declare(strict_types=1);

namespace Coeliac\Base;

abstract class Modules
{
    abstract public function getProviders(): array;
}
