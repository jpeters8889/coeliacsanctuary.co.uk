<?php

declare(strict_types=1);

namespace Coeliac\Common\MjmlCompiler;

interface CompilerContract
{
    public function compile(string $mjml): array;
}
