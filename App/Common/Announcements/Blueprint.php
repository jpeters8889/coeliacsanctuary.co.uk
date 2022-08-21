<?php

declare(strict_types=1);

namespace Coeliac\Common\Announcements;

use Coeliac\Common\Models\Announcement;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return Announcement::class;
    }

    public function blueprintSite(): string
    {
        return 'Site';
    }

    public function plans(): array
    {
        return [
            Textfield::generate('title'),

            Textarea::generate('text')->hideOnIndex(),

            Boolean::generate('live'),

            DateTime::generate('expires_at'),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }

    public function searchable(): bool
    {
        return false;
    }
}
