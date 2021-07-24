<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Architect;

use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textfield;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Modules\Member\Models\LoginAttempt;

class LoginAttemptsBlueprint extends Blueprint
{
    public function model(): string
    {
        return LoginAttempt::class;
    }

    public function ordering(): array
    {
        return ['created_at', 'desc'];
    }

    public function blueprintSite(): string
    {
        return 'Logs';
    }

    public function blueprintRoute(): string
    {
        return 'login-attempts';
    }

    public function blueprintName(): string
    {
        return 'Login Attempts';
    }

    public function canEdit(): bool
    {
        return false;
    }

    public function plans(): array
    {
        return [
            Textfield::generate('email'),

            Textfield::generate('ip'),

            Boolean::generate('success'),

            Boolean::generate('failed'),

            Textfield::generate('response'),

            DateTime::generate('created_at'),
        ];
    }
}
