<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\Reviews\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Common\Comments\Commentable;
use Coeliac\Common\Contracts\HasComments;
use Coeliac\Common\Traits\ArchitectModel;
use Coeliac\Common\Traits\ClearsCache;
use Coeliac\Common\Traits\DisplaysImages;
use Coeliac\Common\Traits\HasRichText;
use Coeliac\Common\Traits\Imageable;
use Coeliac\Common\Traits\Linkable;
use Coeliac\Modules\Collection\Traits\IsCollectionItem;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatCounty;
use Coeliac\Modules\Member\Traits\CanBeAddedToScrapbook;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Laravel\Scout\Searchable;

/**
 * @extends BaseModel<Review>
 *
 * @property mixed        $title
 * @property mixed        $meta_description
 * @property mixed        $meta_keywords
 * @property WhereToEat   $eatery
 * @property mixed        $knowledge_rating
 * @property mixed        $presentation_taste_rating
 * @property mixed        $value_rating
 * @property mixed        $general_rating
 * @property mixed|string $overall_rating
 * @property mixed        $meta_tags
 * @property mixed        $live
 * @property mixed        $id
 * @property mixed        $architect_title
 * @property mixed        $link
 * @property Carbon       $created_at
 * @property mixed        $meta_desc
 *
 * @method transform(array $array)
 */
class Review extends BaseModel implements HasComments
{
    use ArchitectModel;
    use CanBeAddedToScrapbook;
    use ClearsCache;
    use Commentable;
    use DisplaysImages;
    use HasRichText;
    use Imageable;
    use IsCollectionItem;
    use Linkable;
    use Searchable;

    protected $appends = [
        'architect_title',
        'main_image',
    ];

    protected $hidden = ['images'];

    protected static function titleField(): array
    {
        return ['title', 'eatery.town.town', 'eatery.county.county'];
    }

    protected static function booted()
    {
        static::creating(static function (Review $review) {
            $overallRating = array_sum([
                    $review->knowledge_rating,
                    $review->presentation_taste_rating,
                    $review->value_rating,
                    $review->general_rating,
                ]) / 4;

            $overallRating = round($overallRating * 2) / 2;
            $review->overall_rating = number_format($overallRating, 1);
        });
    }

    public function getArchitectTitleAttribute(): string
    {
        return $this->title.', '.$this->eatery->town->town;
    }

    public function eatery(): HasOne
    {
        return $this->hasOne(WhereToEat::class, 'id', 'wheretoeat_id');
    }

    public function wheretoeat(): HasOne
    {
        return $this->hasOne(WhereToEat::class, 'id', 'wheretoeat_id');
    }

    public function county(): HasOneThrough
    {
        return $this->hasOneThrough(WhereToEatCounty::class, WhereToEat::class, 'id', 'id', 'wheretoeat_id', 'county_id');
    }

    protected function linkRoot(): string
    {
        return 'review';
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->title.', '.$this->eatery->town->town,
            'location' => $this->eatery->town->town.', '.$this->eatery->county->county,
            'description' => $this->meta_description,
            'metaTags' => $this->meta_tags,
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return (bool) $this->live;
    }

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    protected function richTextType(): string
    {
        return 'Restaurant';
    }

    protected function toRichText(): array
    {
        $address = explode('<br />', $this->eatery->address);

        return [
            '@id' => $this->eatery->website,
            'name' => $this->architect_title,
            'image' => $this->main_image,
            'sameAs' => $this->eatery->website,
            'servesCuisine' => $this->eatery->cuisine->cuisine,
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => $address[0],
                'addressRegion' => $address[count($address) - 2],
                'postalCode' => $address[count($address) - 1],
                'addressCounty' => 'UK',
            ],
            'telephone' => $this->eatery->phone,
            'geo' => [
                '@type' => 'GeoCoordinates',
                'latitude' => $this->eatery->lat,
                'longitude' => $this->eatery->lng,
            ],
            'review' => [
                '@type' => 'Review',
                'url' => 'https://www.coeliacsanctuary.co.uk'.$this->link,
                'author' => [
                    '@type' => 'Person',
                    'name' => 'Alison Wheatley',
                ],
                'publisher' => [
                    '@type' => 'Organization',
                    'name' => 'Coeliac Sanctuary',
                    'sameAs' => 'https://www.coeliacsanctuary.co.uk',
                ],
                'datePublished' => $this->created_at->format('c'),
                'description' => $this->meta_desc,
                'inLanguage' => 'en',
                'reviewRating' => [
                    '@type' => 'Rating',
                    'worstRating' => 0,
                    'bestRating' => 5,
                    'ratingValue' => $this->overall_rating,
                ],
            ],
        ];
    }

    protected static function usesImages(): bool
    {
        return true;
    }

    protected function cacheKey(): string
    {
        return 'reviews';
    }
}
