<?php

declare(strict_types=1);

namespace Coeliac\Architect\Pages\DispatchSlips;

use JPeters\Architect\Pages\Page as ArchitectPage;

class Page implements ArchitectPage
{
    public function vueComponent(): string
    {
        return 'dispatch-slips-page';
    }
}
