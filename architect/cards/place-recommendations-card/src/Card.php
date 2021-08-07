<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\PlaceRecommendationsCard;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'place-recommendations-card-card';
    }

    public function modelParameters(): array
    {
        return [
            'id',
            'name',
            'email',
            'place_name',
            'place_location',
            'place_web_address',
            'place_venue_type_id',
            'place_details',
            'completed',
            'created_at',
        ];
    }
}
