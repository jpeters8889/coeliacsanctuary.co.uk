<?php

namespace Coeliac\Architect\Cards\WteSuggestedEdits;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'wte-suggested-edits-card';
    }

    public function modelParameters(): array
    {
        return [];
    }
}
