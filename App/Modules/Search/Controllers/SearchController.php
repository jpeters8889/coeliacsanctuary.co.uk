<?php

declare(strict_types=1);

namespace Coeliac\Modules\Search\Controllers;

use Illuminate\Support\Str;
use Laravel\Scout\Searchable;
use Spatie\Geocoder\Geocoder;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Support\Collection;
use Illuminate\Container\Container;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Search\Requests\SearchRequest;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class SearchController extends BaseController
{
    private array $models;

    public function __construct()
    {
        $this->models = [
            'blogs' => Blog::class,
            'reviews' => Review::class,
            'recipes' => Recipe::class,
            'eateries' => WhereToEat::class,
            'products' => ShopProduct::class,
        ];
    }

    public function create(SearchRequest $request)
    {
        $request->logSearch();

        $results = new Collection();

        foreach ($this->models as $area => $model) {
            /* @var Searchable $model */
            if ($request->input("areas.{$area}") === false) {
                continue;
            }

            $with = [
                'getRankingInfo' => true,
            ];

            $relations = ['images', 'images.image'];

            if ($area === 'blogs') {
                $with['restrictSearchableAttributes'] = 'title,description,metaTags,tags';
            }

            if ($area === 'eateries') {
                $relations = ['town', 'county', 'country', 'ratings'];

                $geocoder = Container::getInstance()->make(Geocoder::class)->getCoordinatesForAddress($request->input('search'));

                if (isset($geocoder['lat'], $geocoder['lng'])) {
                    $wteWith = [
                        'getRankingInfo' => true,
                        'aroundLatLng' => implode(', ', [$geocoder['lat'], $geocoder['lng']]),
                        'aroundRadius' => (int) round(2 * 1609.344),
                    ];
                }
            }

            if($area === 'reviews') {
                $relations += ['eatery', 'eatery.ratings', 'eatery.town', 'eatery.county', 'eatery.country'];
            }

            $thisResults = $model::search($request->input('search'))
                ->with($with)
                ->get()
                ->load($relations);

            if ($area === 'eateries') {
                $thisResults = $thisResults->reject(static function (WhereToEat $eatery) {
                    return $eatery->town->town === 'Nationwide';
                });
            }

            $results = $results->concat($thisResults);

            if (isset($wteWith)) {
                $results = $results->concat(
                    $model::search()
                        ->with($wteWith)
                        ->get()
                        ->load('town', 'county', 'country', 'ratings')
                        ->reject(static function (WhereToEat $eatery) {
                            return $eatery->town->town === 'Nationwide';
                        })
                );
            }
        }

        $results = $results->sort(function (BaseModel $first, BaseModel $second) {
            /** @phpstan-ignore-next-line  */
            return $second->scoutMetadata()['_rankingInfo']['userScore'] <=> $first->scoutMetadata()['_rankingInfo']['userScore'];
        })->values();

        return $results->transform(function (BaseModel $model) {
            $merge = [];
            $type = class_basename($model) === 'WhereToEat' ? 'eateries' : Str::lower(Str::plural(class_basename($model)));

            if ($type === 'eateries') {
                /** @var WhereToEat $eatery */
                $eatery = $model;

                $merge = [
                    'lat' => $eatery->lat,
                    'lng' => $eatery->lng,
                    'town' => $eatery->town->town,
                    'county' => $eatery->county->county,
                    'country' => $eatery->country->country,
                    'link' => '/wheretoeat/'.$eatery->county->slug.'/'.$eatery->town->slug,
                    'title' => $eatery->name,
                    'description' => $eatery->info,
                ];
            }

            if ($type === 'reviews') {
                /** @var Review $review */
                $review = $model;
                $merge = [
                    'title' => $review->title.', '.$review->eatery->town->town.', '.$review->eatery->county->county,
                ];
            }

            /** @var Blog $blog */
            $blog = $model;

            return array_merge([
                'score' => $blog->scoutMetadata()['_rankingInfo']['userScore'],
                'type' => $type,
                'id' => $blog->id,
                'link' => $blog->link,
                'title' => $blog->title,
                'description' => $blog->meta_description,
                'image' => $blog->main_image ?? $blog->first_image,
            ], $merge);
        });
    }
}
