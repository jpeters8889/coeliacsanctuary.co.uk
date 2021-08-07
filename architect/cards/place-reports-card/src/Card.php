<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceReportsCard;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'place-reports-card-card';
    }

    public function modelParameters(): array
    {
        return [
            'id',
            'wheretoeat_id',
            'completed',
            'details',
            'created_at',
        ];
    }
}
