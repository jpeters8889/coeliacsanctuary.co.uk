<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Architect;

use Illuminate\Support\Collection;
use JPeters\Architect\Plans\Group;
use JPeters\Architect\Plans\Label;
use JPeters\Architect\Plans\Lookup;
use JPeters\Architect\Plans\Select;
use JPeters\Architect\Plans\Boolean;
use JPeters\Architect\Plans\Switcher;
use JPeters\Architect\Plans\Textarea;
use JPeters\Architect\Plans\Textfield;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Architect\Plans\AddressLookup\Plan;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Architect\Plans\WteAttractions\Plan as WteAttractions;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;

class WhereToEatBlueprint extends Blueprint
{
    public function model(): string
    {
        return WhereToEat::class;
    }

    public function getData(): Builder
    {
        return parent::getData()
            ->join('wheretoeat_countries', 'wheretoeat.country_id', '=', 'wheretoeat_countries.id')
            ->join('wheretoeat_counties', 'wheretoeat.county_id', '=', 'wheretoeat_counties.id')
            ->join('wheretoeat_towns', 'wheretoeat.town_id', '=', 'wheretoeat_towns.id')
            ->with(['country', 'county', 'town', 'type'])
            ->without('ratings')
            ->addSelect([
                'wheretoeat.id', 'wheretoeat.town_id', 'wheretoeat.county_id', 'wheretoeat.country_id', 'type_id',
                'name', 'address', 'phone', 'website', 'live', 'venue_type_id', 'cuisine_id', 'info',
//                'country_description' => 'wheretoeat_countries.country',
//                'county_description' => 'wheretoeat_counties.county',
//                'town_description' => 'wheretoeat_towns.town',
            ]);
    }

    public function primaryField(): string
    {
        return 'wheretoeat.id';
    }

    public function blueprintName(): string
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

            Lookup::generate('town_id', 'Town')
                ->hideOnIndex()
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
                }),

            Select::generate('county_id', 'County')
                ->hideOnIndex()
                ->options($this->getCounties()->toArray())
                ->addListener('town_id', 'changed', static function ($value) {
                    return $value['county_id'];
                }),

            Select::generate('country_id', 'Country')
                ->hideOnIndex()
                ->options($this->getCountries()->toArray())
                ->addListener('town_id', 'changed', static function ($value) {
                    return WhereToEatCounty::query()->find($value['county_id'])->country_id;
                }),

            Plan::generate('address')->hideOnIndex(),

            Textfield::generate('phone')->hideOnIndex(),

            Textfield::generate('website')->hideOnIndex(),

            Label::generate('full_location', 'Location')->hideOnForms(),
//
            Label::generate('type_description', 'Type')->hideOnForms(),
//
            Boolean::generate('live'),

            Switcher::generate('type_id', 'Type')
                ->hideOnIndex()
                ->isInRelationship('type')
                ->options($this->getTypes()->toArray())
                ->addPlansForOption(1, [
                    Select::generate('venue_type_id', 'VenueType')
                        ->isInRelationship(null)
                        ->options($this->getVenueTypes(1)->toArray()),

                    Select::generate('cuisine_id', 'Cuisine')
                        ->options(
                            WhereToEatCuisine::query()->get()
                                ->mapWithKeys(function (WhereToEatCuisine $cuisine) {
                                    return [$cuisine->id => $cuisine->cuisine];
                                })->toArray()
                        ),

                    Textarea::generate('info'),

                    Group::generate('features')
                        ->setPivotRelationship('features')
                        ->wrapPlans()
                        ->plans($this->getFeatures(1)),
                ])
                ->addPlansForOption(2, [
                    Select::generate('venue_type_id', 'Venue Type')
                        ->options($this->getVenueTypes(2)->toArray()),

                    WteAttractions::generate('Restaurants'),
                ])
                ->addPlansForOption(3, [
                    Textarea::generate('info'),

                    Group::generate('features')
                        ->setPivotRelationship('features')
                        ->wrapPlans()
                        ->plans($this->getFeatures(3)),
                ]),
        ];
    }

    private function getFeatures($type)
    {
        return WhereToEatFeature::query()
            ->where('type_id', $type)
            ->get()
            ->transform(static function (WhereToEatFeature $feature) {
                return new Boolean($feature->id, $feature->feature);
            })
            ->toArray();
    }

    private function getVenueTypes($type = null)
    {
        $query = WhereToEatVenueType::query();

        if ($type) {
            $query->where('type_id', $type);
        }

        return $query->get()
            ->mapWithKeys(function (WhereToEatVenueType $venueType) {
                return [$venueType->id => $venueType->venue_type];
            });
    }

    private function getCounties()
    {
        return WhereToEatCounty::query()
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
            'type_id' => [
                'name' => 'Type',
                'options' => $this->getTypes(),
                'filter' => fn (Builder $builder, $value) => $builder->where('type_id', $value),
            ],
            'venue_type_id' => [
                'name' => 'Venue Type',
                'options' => $this->getVenueTypes(),
                'filter' => fn (Builder $builder, $value) => $builder->where('venue_type_id', $value),
            ],
            'country_id' => [
                'name' => 'Country',
                'options' => $this->getCountries(),
                'filter' => fn (Builder $builder, $value) => $builder->where('country_id', $value),
            ],
            'county_id' => [
                'name' => 'County',
                'options' => $this->countiesForFilters(),
                'filter' => fn (Builder $builder, $value) => $builder->where('wheretoeat.county_id', $value),
            ],
            'town_id' => [
                'name' => 'Town',
                'options' => WhereToEatTown::query()
                    ->orderBy('town')
                    ->get()
                    ->mapWithKeys(fn (WhereToEatTown $town) => [$town->id => $town->town]),
                'filter' => fn (Builder $builder, $value) => $builder->where('wheretoeat.town_id', $value),
            ],
        ];
    }

    protected function countiesForFilters()
    {
        $counties = new Collection();

        $this->getCounties()->each(function (Collection $group) use (&$counties) {
            $group->each(fn ($county, $id) => $counties->put($id, $county));
        });

        return $counties->sort();
    }
}
