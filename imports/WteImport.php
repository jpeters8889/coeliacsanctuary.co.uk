<?php

declare(strict_types=1);

namespace Imports;

use Illuminate\Support\Str;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatType;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCountry;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCuisine;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatFeature;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatVenueType;

class WteImport extends Import
{
    public function handle()
    {
        $this->command->info('Adding Counties');

        $seedCounties = $this->seedDatabase->table('wheretoeat_counties')->get();

        WhereToEatCounty::query()->create([
            'county' => 'Nationwide',
            'slug' => 'nationwide',
            'legacy' => 'Nationwide',
            'country_id' => 1,
        ]);

        $bar = $this->command->makeProgressBar(count($seedCounties));
        $bar->start();

        foreach ($seedCounties as $county) {
            $legacy = $county->county;

            if ($legacy !== 'West Midlands' && preg_match('/(north|south|east|west) ((.*)+)/mi', $county->county, $match)) {
                $legacy = $match[2].' ('.$match[1].')';
            }

            WhereToEatCounty::query()->create([
                'county' => $county->county,
                'slug' => Str::slug($county->county),
                'legacy' => $legacy,
                'country_id' => $this->findInArray(WhereToEatCountry::class, 'country', $county->country),
            ]);

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('Adding Towns');

        $towns = $this->seedDatabase->table('wheretoeat')->groupBy(['town', 'county'])->get(['town', 'county']);

        $bar = $this->command->makeProgressBar(count($towns));
        $bar->start();

        foreach ($towns as $town) {
            WhereToEatTown::query()->create([
                'town' => $town->town,
                'slug' => Str::slug($town->town),
                'legacy' => $town->town,
                'county_id' => $this->findInArray(WhereToEatCounty::class, 'legacy', $town->county),
            ]);

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('Adding Venue Types');

        $venueTypes = $this->seedDatabase->table('wheretoeat')->distinct()->selectRaw('distinct(venueType), type')->get();

        $bar = $this->command->makeProgressBar(count($venueTypes));
        $bar->start();

        foreach ($venueTypes as $venueType) {
            $type = 1;

            if ($venueType->type !== 'wte') {
                $type = 2;
            }

            WhereToEatVenueType::query()->create([
                'venue_type' => $venueType->venueType,
                'type_id' => $type,
            ]);

            $bar->advance();
        }

        $bar->finish();

        WhereToEatVenueType::query()->create([
            'venue_type' => 'Hotel',
            'type_id' => 3,
        ]);

        $this->command->info('Adding Cuisine Types');

        $cuisineTypes = $this->seedDatabase->table('wheretoeat')->distinct()->get(['cuisine']);

        $bar = $this->command->makeProgressBar(count($cuisineTypes));
        $bar->start();

        foreach ($cuisineTypes as $cuisineType) {
            WhereToEatCuisine::query()->create([
                'cuisine' => $cuisineType->cuisine,
            ]);

            $bar->advance();
        }

        $bar->finish();

        $this->command->info('Adding places to eat');

        $seeds = $this->seedDatabase->table('wheretoeat')->get();

        $bar = $this->command->makeProgressBar(count($seeds));
        $bar->start();

        foreach ($seeds as $seed) {
            $features = json_decode($seed->features);

            if ($seed->type === 'hotel') {
                $features = json_decode($seed->venueType);
                $seed->venueType = 'Hotel';
            }

            /** @var WhereToEat $new */
            $new = WhereToEat::query()->create([
                'name' => $seed->name,
                'town_id' => WhereToEatTown::query()
                    ->where('town', $seed->town)
                    ->where('county_id', $this->findInArray(WhereToEatCounty::class, 'legacy', $seed->county))
                    ->value('id'),
                'county_id' => $this->findInArray(WhereToEatCounty::class, 'legacy', $seed->county),
                'country_id' => $this->findInArray(WhereToEatCountry::class, 'country', $seed->country),
                'info' => $seed->info,
                'address' => $seed->address,
                'phone' => $seed->phone,
                'website' => $seed->website,
                'lat' => $seed->lat,
                'lng' => $seed->lng,
                'type_id' => $this->findInArray(WhereToEatType::class, 'type', $seed->type),
                'venue_type_id' => $this->findInArray(WhereToEatVenueType::class, 'venue_type', $seed->venueType, 1),
                'cuisine_id' => $this->findInArray(WhereToEatCuisine::class, 'cuisine', $seed->cuisine),
                'live' => $seed->live,
                'created_at' => $seed->created_at,
                'updated_at' => $seed->updated_at,
            ]);

            if ($features) {
                foreach ($features as $feature => $set) {
                    if ($set) {
                        $new->features()->attach($this->findInArray(WhereToEatFeature::class, 'icon', $feature));
                    }
                }
            }

            $bar->advance();
        }

        $bar->finish();
    }
}
