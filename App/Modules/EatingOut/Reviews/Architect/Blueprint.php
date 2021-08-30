<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Architect;

use JPeters\Architect\Plans\Body;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Lookup;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\DateTime;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use Coeliac\Architect\Plans\ImageManager\Plan;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use JPeters\Architect\Blueprints\Blueprint as ArchitectBlueprint;

class Blueprint extends ArchitectBlueprint
{
    public function model(): string
    {
        return Review::class;
    }

    public function getData(): Builder
    {
        return parent::getData()->addSelect('title', 'slug', 'id', 'wheretoeat_id', 'live', 'meta_description', 'created_at')
            ->with(['eatery', 'eatery.town', 'eatery.county', 'eatery.country', 'images']);
    }

    public function plans(): array
    {
        return [
            Lookup::generate('wheretoeat_id', 'Place')
                ->hideOnIndex()
                ->setLookupVariable('full_name')
                ->setLookupAttribute('id')
                ->isInRelationship('id')
                ->lookupAction(static function ($value) {
                    return WhereToEat::query()
                        ->where('name', 'LIKE', '%'.$value.'%')
                        ->first(['id', 'name', 'town_id', 'county_id', 'country_id'])
                        ->take(10)
                        ->get()
                        ->makeVisible('full_name')
                        ->makeHidden(['type_description', 'icon', 'ratings']);
                })
                ->fetchValueFrom(static function ($value) {
                    return WhereToEat::query()
                        ->where('id', $value)
                        ->first(['id', 'name', 'town_id', 'county_id', 'country_id'])
                        ->makeVisible('full_name')
                        ->makeHidden(['type_description', 'icon', 'ratings']);
                }),

            Textfield::generate('title')->hideOnIndex(),

            Label::generate('architect_title', 'Title')->hideOnForms(),

            Textfield::generate('meta_tags')->hideOnIndex(),

            Textarea::generate('meta_description'),

            Boolean::generate('live', 'Published'),

            Plan::generate('Images')
                ->disableSquareImageOption()
                ->enableImageInserts('architect_body')
                ->hideOnIndex(),

            Select::generate('knowledge_rating')
                ->hideOnIndex()
                ->hideDefault()
                ->options($this->getRatingOptions()),

            Select::generate('presentation_taste_rating')
                ->hideOnIndex()
                ->hideDefault()
                ->options($this->getRatingOptions()),

            Select::generate('value_rating')
                ->hideOnIndex()
                ->hideDefault()
                ->options($this->getRatingOptions()),

            Select::generate('general_rating')
                ->hideOnIndex()
                ->hideDefault()
                ->options($this->getRatingOptions()),

            Body::generate('architect_body', 'Body')->hideOnIndex(),

            DateTime::generate('created_at')->hideOnForms(),
        ];
    }

    protected function getRatingOptions(): array
    {
        $values = [
            '0.5',
            '1.0',
            '1.5',
            '2.0',
            '2.5',
            '3.0',
            '3.5',
            '4.0',
            '4.5',
            '5.0',
        ];

        return array_combine($values, $values);
    }

    public function filters(): array
    {
        return [
            'live' => [
                'name' => 'Published',
                'options' => [
                    1 => 'Yes',
                    0 => 'No',
                ],
                'filter' => fn (Builder $builder, $value) => $builder->where('live', $value),
            ],
        ];
    }
}
