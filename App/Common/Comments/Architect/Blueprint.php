<?php

declare(strict_types=1);

namespace Coeliac\Common\Comments\Architect;

use Coeliac\Common\Models\Comment;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Architect\Cards\Comments\Card;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return Comment::class;
    }

    public function makeVisible(): array
    {
        return ['email', 'link', 'area', 'commentable', 'commentable_type', 'reply', 'approved', 'id'];
    }

    public function blueprintSite(): string
    {
        return 'Approvals';
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->with(['commentable', 'reply', 'commentable.images'])
            ->select('*');
    }

    public function plans(): array
    {
        return [];
    }

    public function card(): ?string
    {
        return Card::class;
    }

    public function displayCount(): int
    {
        return Comment::query()->where('approved', 0)->count();
    }

    public function canEdit(): bool
    {
        return false;
    }
}
