<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Architect;

use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Modules\Member\Models\UserPasswordChange;

class PasswordChangesBlueprint extends Blueprint
{
    public function model(): string
    {
        return UserPasswordChange::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->join('users', 'users.id', '=', 'user_password_changes.id');
    }

    public function ordering(): array
    {
        return ['changed_at', 'desc'];
    }

    public function blueprintSite(): string
    {
        return 'Logs';
    }

    public function blueprintRoute(): string
    {
        return 'password-changes';
    }

    public function blueprintName(): string
    {
        return 'Password Changes';
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function primaryField(): string
    {
        return 'user_password_changes.id';
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name', 'User Name'),

            DateTime::generate('changed_at'),
        ];
    }
}
