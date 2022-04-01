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
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use JPeters\Architect\Blueprints\Blueprint;
use Coeliac\Architect\Plans\AddressLookup\Plan;
use JPeters\Architect\Plans\BulkBlueprintVariants;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Architect\Plans\WteAttractions\Plan as WteAttractions;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;
use Coeliac\Architect\Plans\WteOpeningTimes\Plan as OpeningTimesPlan;

// @todo - add lookup to recommend a place, see if place already exists
// @todo - add photos to leave a review
// @todo - review admin
// @todo - shop product variant live toggle
// @todo - cant scroll on filters modal on wte admin
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
            ->with(['country', 'county', 'town', 'type', 'county.country', 'openingTimes'])
            ->without('ratings')
            ->addSelect([
                'wheretoeat.id', 'wheretoeat.town_id', 'wheretoeat.county_id', 'wheretoeat.country_id', 'type_id',
                'name', 'address', 'phone', 'website', 'live', 'venue_type_id', 'cuisine_id', 'info',
            ]);
    }

    public function blueprintName(): string
    {
        return 'Where to Eat';
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

            Label::generate('full_location', 'Location')->hideOnForms(),

            Label::generate('type_description', 'Type')->hideOnForms(),

            BulkBlueprintVariants::generate('locations')
                ->setAddButtonLabel('Add Location')
                ->plans([
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
                            $request = json_decode(request()->input('locations'));

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

                    Plan::generate('address'),

                    Textfield::generate('phone'),
                ]),

            Textfield::generate('website')->hideOnIndex(),

            Textfield::generate('gf_menu_link')->hideOnIndex(),

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

                    $this->openingTimesPlan(),
                ])
                ->addPlansForOption(2, [
                    Select::generate('venue_type_id', 'Venue Type')
                        ->options($this->getVenueTypes(2)->toArray()),

                    WteAttractions::generate('Restaurants'),

                    $this->openingTimesPlan(),
                ])
                ->addPlansForOption(3, [
                    Textarea::generate('info'),
                ]),

            Group::generate('features')
                ->setPivotRelationship('features')
                ->wrapPlans()
                ->plans($this->getFeatures()),
        ];
    }

    protected function openingTimesPlan(): OpeningTimesPlan
    {
        return OpeningTimesPlan::generate('openingTimes', 'Opening Times')
            ->hideOnIndex();
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

    private function getCuisines()
    {
        return WhereToEatCuisine::query()
            ->get()
            ->mapWithKeys(function (WhereToEatCuisine $cuisine) {
                return [$cuisine->id => $cuisine->cuisine];
            });
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
                'filter' => fn(Builder $builder, $value) => $builder->where('live', $value),
            ],
            'type_id' => [
                'name' => 'Type',
                'options' => $this->getTypes(),
                'filter' => fn(Builder $builder, $value) => $builder->where('type_id', $value),
            ],
            'venue_type_id' => [
                'name' => 'Venue Type',
                'options' => $this->getVenueTypes(),
                'filter' => fn(Builder $builder, $value) => $builder->where('venue_type_id', $value),
            ],
            'cuisine_id' => [
                'name' => 'Cuisine',
                'options' => $this->getCuisines(),
                'filter' => fn(Builder $builder, $value) => $builder->where('cuisine_id', $value),
            ],
            'country_id' => [
                'name' => 'Country',
                'options' => $this->getCountries(),
                'filter' => fn(Builder $builder, $value) => $builder->where('country_id', $value),
            ],
            'county_id' => [
                'name' => 'County',
                'options' => $this->countiesForFilters(),
                'filter' => fn(Builder $builder, $value) => $builder->where('wheretoeat.county_id', $value),
            ],
            'town_id' => [
                'name' => 'Town',
                'options' => WhereToEatTown::query()
                    ->orderBy('town')
                    ->get()
                    ->mapWithKeys(fn(WhereToEatTown $town) => [$town->id => $town->town]),
                'filter' => fn(Builder $builder, $value) => $builder->where('wheretoeat.town_id', $value),
            ],
        ];
    }

    protected function countiesForFilters()
    {
        $counties = new Collection();

        $this->getCounties()->each(function (Collection $group) use (&$counties) {
            $group->each(fn($county, $id) => $counties->put($id, $county));
        });

        return $counties->sort();
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
}
