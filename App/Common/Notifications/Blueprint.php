<?php

declare(strict_types=1);

namespace Coeliac\Common\Notifications;

use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Button;
use JPeters\Architect\Plans\DateTime;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Common\Models\NotificationEmail;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return NotificationEmail::class;
    }

    public function blueprintSite(): string
    {
        return 'Logs';
    }

    public function blueprintName(): string
    {
        return 'Notification Emails';
    }

    public function getData(): Builder
    {
        return parent::getData()->select('*');
    }

    public function plans(): array
    {
        return [
            Label::generate('email_address', 'To Email'),
            Label::generate('template'),
            DateTime::generate('created_at', 'Sent At'),
            Button::generate('View Email')
                ->openAsLink()
                ->onClick(static function (NotificationEmail $email) {
                    return "/email/{$email->key}";
                }),
        ];
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function searchable(): bool
    {
        return true;
    }

    public function filters(): array
    {
        return [
            'template' => [
                'name' => 'Template',
                'options' => NotificationEmail::query()->groupBy('template')
                    ->get('template')
                    ->mapWithKeys(fn (NotificationEmail $email) => [$email['template'] => $email['template']]),
                'filter' => fn (Builder $builder, $value) => $builder->where('template', $value),
            ],
        ];
    }
}
