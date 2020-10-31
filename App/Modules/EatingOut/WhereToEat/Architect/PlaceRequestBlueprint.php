<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Architect\Cards\PlaceRequestCard\Card;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;

class PlaceRequestBlueprint extends Blueprint
{
    public function model(): string
    {
        return PlaceRequest::class;
    }

    public function plans(): array
    {
        return [];
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function blueprintName(): string
    {
        return 'Place Requests';
    }

    public function displayCount(): int
    {
        return PlaceRequest::query()->where('completed', 0)->count();
    }
}
