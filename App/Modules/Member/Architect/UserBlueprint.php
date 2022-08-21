<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Architect;

use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Member\Models\UserLevel;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Password;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Textfield;

class UserBlueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return User::class;
    }

    public function makeVisible(): array
    {
        return ['user_level_id'];
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->withCount(['orders', 'scrapbooks', 'scrapbookItems', 'subscriptions']);
    }

    public function ordering(): array
    {
        return ['name', 'asc'];
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name'),

            Textfield::generate('email'),

            Password::generate('password'),

            Select::generate('user_level_id', 'User Level')
                ->options($this->getUserLevels()->toArray()),

            Label::generate('orders_count', 'Orders')->hideOnForms(),

            Label::generate('scrapbooks_count', 'Scrapbooks')->hideOnForms(),

            Label::generate('scrapbook_items_count', 'Scrapbooked Items')->hideOnForms(),

            Label::generate('subscriptions_count', 'Update Subscriptions')->hideOnForms(),

            DateTime::generate('last_visited_at', 'Last Visit')->hideOnForms(),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }

    private function getUserLevels()
    {
        return UserLevel::query()
            ->get()
            ->mapWithKeys(static fn (UserLevel $level) => [$level->id => $level->description]);
    }

    public function filters(): array
    {
        return [
            'user_level_id' => [
                'name' => 'User Level',
                'options' => UserLevel::query()
                    ->get()
                    ->mapWithKeys(fn (UserLevel $level) => [$level->id => $level->description]),
                'multi' => true,
                'default' => '2,3',
                'filter' => fn (Builder $builder, $value) => $builder->whereIn('user_level_id', explode(',', $value)),
            ],
        ];
    }
}
