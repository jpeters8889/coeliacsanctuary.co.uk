<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Coeliac\Architect\Cards\PlaceRequestCard\Card;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;
use JPeters\Architect\Blueprints\Blueprint;

class PlaceRequestBlueprint extends Blueprint
{
    public function model(): string
    {
        return PlaceRequest::class;
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function plans(): array
    {
        return [];
    }

    public function blueprintSite(): string
    {
        return 'Approvals';
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
