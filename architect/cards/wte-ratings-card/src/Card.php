<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\WteRatingsCard;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'wte-ratings-card-card';
    }

    public function modelParameters(): array
    {
        return [];
    }
}
