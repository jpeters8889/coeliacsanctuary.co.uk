<?php

declare(strict_types=1);

namespace Coeliac\Common\Imports;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class WteSearchImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $collection)
    {
        return $collection->map(function (Collection $item) {
            $result = $this->buildBaseObject($item);

            try {
                $this->findLocation($result);
                $this->findEatery($result);
            } catch (Exception $exception) {
                $result['error'] = true;
                $result['message'] = $exception->getMessage();
            }

            return collect($result);
        });
    }

    public function findEatery(&$item): void
    {
        $eateryName = Arr::get($item, 'name');

        if (Str::of($eateryName)->lower()->startsWith('the')) {
            $eateryName = Str::replaceFirst('The ', '', $eateryName);
        }

        $eateryName = Str::replace("'", '', $eateryName);
        $eateryName = Str::replace(['and', '&'], '%', $eateryName);

        $search = WhereToEat::query()
            ->where(function(Builder $builder) use ($item) {
                $builder->where('town_id', Arr::get($item, 'town.id'))
                    ->orWhere('county_id', Arr::get($item, 'county.id'));
            })
            ->whereRaw("replace(replace(name, '’', ''), '\'', '') like ?", ["%{$eateryName}%"])
            ->get();

        if($search->count() > 1) {
            $search = $search->reject(fn(WhereToEat $eatery) => $eatery->town_id !== Arr::get($item, 'town.id'));

            if($search->count() > 1) {
                $search = $search->reject(fn(WhereToEat $eatery) => $eatery->live === 0);

                if($search->count() > 1) {
                    throw new Exception("Multiple matching live eateries found in the town");
                }
            }
        }

        $eatery = $search->first();

        if($eatery) {
            $item['wheretoeat_id'] = $eatery->id;
            $item['exists'] = true;
            $item['live'] = $eatery->live;
        }
    }

    protected function findLocation(&$item): void
    {
        $town = Arr::get($item, 'town.name');
        $county = Arr::get($item, 'county.name');

        /** @var WhereToEatTown | null $town */
        $towns = WhereToEatTown::query()->where('town', 'like', "%{$town}%")->get();
//        $towns = WhereToEatTown::query()->where('town', 'like', "{$town}")->get();

        if($towns->isEmpty()) {
            throw new Exception("Can't find any town with the name {$town}");
        }

        if($towns->count() > 1) {
            $countyModel = WhereToEatCounty::query()->where('county', $county)->first();

            if(!$countyModel) {
                throw new Exception("Found multiple results for {$town}, but can't find a county for {$county}");
            }

            $towns = $towns->filter(fn(WhereToEatTown $town) => $town->county_id === $countyModel->id);

            if($towns->count() > 1) {
                throw new Exception("Found multiple results for {$town} in {$county}");
            }
        }

        $townModel = $towns->first();

        if(! $townModel) {
            throw new Exception("Can't find town with the name {$town} or county {$county}");
        }

        $townModel->load('county');

        $item['town'] = [
            'id' => $townModel->id,
            'name' => $townModel->town,
            'eateries' => $townModel->eateries()->count(),
        ];
        $item['county'] = [
            'id' => $townModel->county->id,
            'name' => $townModel->county->county,
        ];
        $item['country'] = [
            'id' => $townModel->county->country->id,
            'name' => $townModel->county->country->country,
        ];
    }

    protected function buildBaseObject(Collection $item): array
    {
        return [
            'error' => false,
            'message' => '',
            'wheretoeat_id' => '',
            'name' => $item->get('chip_shop'),
            'exists' => false,
            'live' => false,
            'country' => [
                'name' => $item->get('country'),
                'id' => '',
            ],
            'county' => [
                'name' => $item->get('county'),
                'id' => '',
            ],
            'town' => [
                'name' => $item->get('town'),
                'id' => '',
                'eateries' => 0,
            ],
        ];
    }
}
