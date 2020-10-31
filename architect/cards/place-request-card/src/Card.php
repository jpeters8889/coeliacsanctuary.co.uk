<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceRequestCard;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'place-request-card-card';
    }

    public function modelParameters(): array
    {
        return [
            'id',
            'name',
            'addOrRemove',
            'completed',
            'details',
            'created_at',
        ];
    }
}
