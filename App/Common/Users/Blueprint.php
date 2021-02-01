<?php

declare(strict_types=1);

namespace Coeliac\Common\Users;

use Coeliac\Modules\Member\Models\User;
use JPeters\Architect\Plans\Select;
use Coeliac\Modules\Member\Models\UserLevel;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Password;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return User::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->where('user_level_id', '!=', 1);
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name'),

            Textfield::generate('email'),

            Password::generate('password'),

            Select::generate('user_level_id', 'User Level')
                ->hideOnIndex()
                ->options($this->getUserLevels()->toArray()),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }

    private function getUserLevels()
    {
        return UserLevel::query()
            ->get()
            ->mapWithKeys(static fn (UserLevel $level) => [$level->id => $level->description]);
    }
}
