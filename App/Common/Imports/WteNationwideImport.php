<?php

declare(strict_types=1);

namespace Coeliac\Common\Imports;

use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Exception;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Spatie\Geocoder\Geocoder;

class WteNationwideImport implements ToCollection, WithHeadingRow
{
    use Importable;

    public function collection(Collection $collection)
    {
        return $collection->map(function (Collection $item) {
            $result = $this->buildBaseObject($item);

            try {
                $this->findTown($result);
                $this->findLatLng($result);
            } catch (Exception $exception) {
                $result['error'] = true;
                $result['message'] = $exception->getMessage();
            }

            return collect($result);
        });
    }

    protected function findLatLng(&$item): void
    {
        $search = $item['name'].', '.$item['address']['raw'];

        $geocoder = app(Geocoder::class);

        $result = $geocoder->getCoordinatesForAddress($search);

        $item['lat'] = $result['lat'];
        $item['lng'] = $result['lng'];
    }

    protected function findTown(&$item): void
    {
        $search = array_slice($item['address']['bits'], -2, 1)[0];
        $secondSearch = array_slice($item['address']['bits'], -3, 1)[0];

        /** @var WhereToEatTown | null $town */
        $town = WhereToEatTown::query()->where('town', $search)->first();

        if(! $town && Str::contains($search, '-')) {
            $search = str_replace('-', ' ', $search);

            $town = WhereToEatTown::query()->where('town', $search)->first();
        }

        if (! $town) {
            $town = WhereToEatTown::query()->where('town', $secondSearch)->first();
        }

        if(! $town) {
            /** @var WhereToEatCounty | null $county */
            $county = WhereToEatCounty::query()->where('county', $search)->first();

            if($county) {
                $town = $county->towns()->make(['town' => $secondSearch]);
            }
        }

        if(! $town) {
            throw new Exception("Can't find town, tried {$search} and {$secondSearch})");
        }

        $item['town'] = [
            'id' => $town->exists ? $town->id : 'NEW',
            'name' => $town->town,
        ];
        $item['county'] = [
            'id' => $town->county->id,
            'name' => $town->county->county,
        ];
        $item['country'] = [
            'id' => $town->county->country->id,
            'name' => $town->county->country->country,
        ];
    }

    protected function buildBaseObject(Collection $item): array
    {
        return [
            'error' => false,
            'message' => '',
            'wheretoeat_id' => $item->get('wheretoeat_id'),
            'name' => $item->get('name'),
            'country' => [
                'id' => '',
                'name' => '',
            ],
            'county' => [
                'id' => '',
                'name' => '',
            ],
            'town' => [
                'id' => '',
                'name' => '',
            ],
            'address' => [
                'raw' => $item->get('address'),
                'formatted' => str_replace(', ', '<br />', $item->get('address', '')),
                'bits' => explode(', ', $item->get('address', '')),
            ],
            'lat' => '',
            'lng' => '',
            'live' => $item->get('live'),
        ];
    }
}
