<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Indices;

use Algolia\ScoutExtended\Builder;
use Spatie\Geocoder\Geocoder;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Collection;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class Eatery extends Index
{
    protected function model(): Builder|\Laravel\Scout\Builder
    {
        return WhereToEat::search($this->term);
    }

    protected function withRelations(): array
    {
        return ['town', 'county', 'country', 'ratings'];
    }

    protected function afterSearching(Collection $results): Collection
    {
        $results = $results->reject(static function (WhereToEat $eatery) {
            return $eatery->town->town === 'Nationwide';
        });

        $geocoder = resolve(Geocoder::class)->getCoordinatesForAddress($this->term);

        if (!isset($geocoder['lat'], $geocoder['lng'])) {
            return $results;
        }

        return $results->concat(
        /** @phpstan-ignore-next-line  */
        WhereToEat::search()->with([
                'getRankingInfo' => true,
                'aroundLatLng' => implode(', ', [$geocoder['lat'], $geocoder['lng']]),
                'aroundRadius' => (int) round(2 * 1609.344),
            ])
            ->get()
            ->load('town', 'county', 'country', 'userReviews')
            ->reject(static function (WhereToEat $eatery) {
                return $eatery->town->town === 'Nationwide';
            })
        );
    }

    protected function mergeIntoResult(BaseModel $result): array
    {
        /** @var WhereToEat $result */

        return [
            'lat' => $result->lat,
            'lng' => $result->lng,
            'town' => $result->town->town,
            'county' => $result->county->county,
            'country' => $result->country->country,
            'link' => '/wheretoeat/'.$result->county->slug.'/'.$result->town->slug,
            'title' => $result->name,
            'description' => $result->info,
        ];
    }
}
