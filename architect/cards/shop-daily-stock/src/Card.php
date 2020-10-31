<?php

declare(strict_types=1);

namespace Coeliac\Architect\Cards\ShopDailyStock;

use JPeters\Architect\Cards\Card as ArchitectCard;

class Card extends ArchitectCard
{
    public function vueComponent(): string
    {
        return 'shop-daily-stock-card';
    }

    public function modelParameters(): array
    {
        return [];
    }
}
