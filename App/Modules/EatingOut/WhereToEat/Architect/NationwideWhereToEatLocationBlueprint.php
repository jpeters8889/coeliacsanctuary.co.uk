<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Coeliac\Architect\Plans\AddressLookup\Plan as Address;
use Coeliac\Architect\Plans\WteNationwideBranches\Plan as Branches;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use JPeters\Architect\Blueprints\Blueprint;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\Group;
use JPeters\Architect\Plans\HiddenField;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Lookup;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Switcher;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;

class NationwideWhereToEatLocationBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEat::class;
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->where('wheretoeat.county_id', 1)
            ->join('wheretoeat_countries', 'wheretoeat.country_id', '=', 'wheretoeat_countries.id')
            ->join('wheretoeat_counties', 'wheretoeat.county_id', '=', 'wheretoeat_counties.id')
            ->join('wheretoeat_towns', 'wheretoeat.town_id', '=', 'wheretoeat_towns.id')
            ->with(['country', 'county', 'town', 'type', 'county.country', 'openingTimes'])
            ->without('ratings')
            ->addSelect([
                'wheretoeat.id', 'wheretoeat.town_id', 'wheretoeat.county_id', 'wheretoeat.country_id', 'type_id',
                'name', 'address', 'phone', 'website', 'live', 'venue_type_id', 'cuisine_id', 'info',
            ]);
    }

    public function blueprintName(): string
    {
        return 'Nationwide Eateries';
    }

    public function blueprintRoute(): string
    {
        return 'nationwide-eateries';
    }

    public function blueprintSite(): string
    {
        return 'Where to Eat';
    }

    public function ordering(): array
    {
        return [
            ['wheretoeat_countries.country'],
            ['wheretoeat_counties.county'],
            ['wheretoeat_towns.town'],
            ['name'],
        ];
    }

    public function plans(): array
    {
        return [
            Textfield::generate('name'),

            Label::generate('type_description', 'Type')->hideOnForms(),

            Textfield::generate('website')->hideOnIndex(),

            Textfield::generate('gf_menu_link')->hideOnIndex(),

            Boolean::generate('live'),

            Switcher::generate('type_id', 'Type')
                ->hideOnIndex()
                ->isInRelationship('type')
                ->options($this->getTypes()->toArray())
                ->addPlansForOption(1, [
                    Select::generate('cuisine_id', 'Cuisine')
                        ->options(
                            WhereToEatCuisine::query()->get()
                                ->mapWithKeys(function (WhereToEatCuisine $cuisine) {
                                    return [$cuisine->id => $cuisine->cuisine];
                                })->toArray()
                        ),

                    Textarea::generate('info'),
                ]),

            Select::generate('venue_type_id', 'VenueType')
                ->isInRelationship(null)
                ->options($this->getVenueTypes()->toArray()),

            Group::generate('features')
                ->setPivotRelationship('features')
                ->hideOnIndex()
                ->wrapPlans()
                ->plans($this->getFeatures()),

            Branches::generate('branches')
                ->plans([
                    HiddenField::generate('id'),

                    Textfield::generate('name'),

                    Boolean::generate('live'),

                    Lookup::generate('town_id', 'Town')
                        ->setLookupVariable('town')
                        ->isInRelationship('town')
                        ->lookupaction(static function ($value) {
                            return WhereToEatTown::query()
                                ->where('town', 'LIKE', "%{$value}%")->take(10)
                                ->get();
                        })
                        ->fetchValueFrom(static function ($value) {
                            return WhereToEatTown::query()
                                ->firstWhere('town', $value);
                        })
                        ->setCreateAction(static function (Model $model, $value, $index) {
                            $request = json_decode(request()->input('branches'));

                            return WhereToEatTown::query()->firstOrCreate([
                                'town' => $value,
                                'county_id' => data_get($request, "{$index}.county_id"),
                            ]);
                        }),

                    Select::generate('county_id', 'County')
                        ->options($this->getCounties()->toArray())
                        ->addListener('town_id', 'changed', static function ($value) {
                            return $value['county_id'];
                        }),

                    Select::generate('country_id', 'Country')
                        ->options($this->getCountries()->toArray())
                        ->addListener('town_id', 'changed', static function ($value) {
                            return WhereToEatCounty::query()->find($value['county_id'])->country_id;
                        }),

                    Address::generate('address'),
                ]),
        ];
    }

    private function getCounties()
    {
        return WhereToEatCounty::query()
            ->with(['country'])
            ->get()
            ->transform(function (WhereToEatCounty $county) {
                return [
                    'id' => $county->id,
                    'county' => $county->county,
                    'country' => $county->country->country,
                ];
            })
            ->keyBy('id')
            ->sortBy('country')
            ->groupBy(function ($county) {
                return $county['country'];
            })
            ->transform(function (Collection $group) {
                return $group->sortBy('county')
                    ->mapWithKeys(function ($item) {
                        return [$item['id'] => $item['county']];
                    });
            });
    }

    private function getCountries()
    {
        return WhereToEatCountry::query()
            ->get()
            ->mapWithKeys(function (WhereToEatCountry $country) {
                return [$country->id => $country->country];
            });
    }

    private function getFeatures()
    {
        return WhereToEatFeature::query()
            ->get()
            ->transform(static function (WhereToEatFeature $feature) {
                return new Boolean($feature->id, $feature->feature);
            })
            ->toArray();
    }

    private function getVenueTypes()
    {
        return WhereToEatVenueType::query()->get()
            ->mapWithKeys(function (WhereToEatVenueType $venueType) {
                return [$venueType->id => $venueType->venue_type];
            });
    }

    private function getTypes()
    {
        return WhereToEatType::query()
            ->get()
            ->mapWithKeys(function (WhereToEatType $type) {
                return [$type->id => $type->name];
            });
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

    public function searchUsing(Builder $builder, string $searchTerm, array $columns = []): Builder
    {
        return $builder
            ->where('wheretoeat.id', $searchTerm)
            ->orWhere('name', 'like', "%{$searchTerm}%")
            ->orWhereRaw('wheretoeat_towns.town like ?', ["%{$searchTerm}%"]);
    }

    public function hasPublicLink(): bool
    {
        return false;
    }

    public function beforeSave(Model $model): Model
    {
        $model->country_id = 1;
        $model->county_id = 1;
        $model->town_id = WhereToEatTown::query()->firstWhere('town', 'Nationwide')->id;

        return $model;
    }
}
