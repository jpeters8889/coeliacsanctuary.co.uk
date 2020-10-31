<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\Comments;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'comments-card';
    }

    public function modelParameters(): array
    {
        return [];
    }
}
