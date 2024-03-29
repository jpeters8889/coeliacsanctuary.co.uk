<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Models;

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
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Traits\CanBeAddedToScrapbook;
use Coeliac\Modules\Member\Traits\CreatesDailyUpdate;
use Fico7489\Laravel\Pivot\Traits\PivotEventTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;

/**
 * @extends BaseModel<Blog>
 *
 * @property string              $title
 * @property Collection<BlogTag> $tags
 * @property mixed               $meta_description
 * @property mixed               $meta_keywords
 * @property mixed               $id
 * @property mixed               $link
 * @property mixed               $live
 * @property Carbon              $created_at
 * @property string              $description
 * @property Carbon $updated_at
 *
 * @method transform(array $array)
 */
class Blog extends BaseModel implements HasComments
{
    use ArchitectModel;
    use CanBeAddedToScrapbook;
    use ClearsCache;
    use Commentable;
    use CreatesDailyUpdate;
    use DisplaysImages;
    use HasRichText;
    use Imageable;
    use IsCollectionItem;
    use Linkable;
    use PivotEventTrait;
    use Searchable;

    protected $appends = ['main_image'];

    protected $hidden = ['images'];

    protected static function booted()
    {
        self::pivotAttached(function ($model, $relationName) {
            if ($relationName !== 'tags') {
                return;
            }

            static::dispatchDailyUpdate($model);
        });
    }

    protected static function dispatchUpdateOnCreate(): bool
    {
        return false;
    }

    public function getScoutKey(): mixed
    {
        return $this->id;
    }

    protected function linkRoot(): string
    {
        return 'blog';
    }

    public function toSearchableArray(): array
    {
        return $this->transform([
            'title' => $this->title,
//            'body' => $this->body,
            'description' => $this->description,
            'metaTags' => $this->meta_keywords ? explode(',', $this->meta_keywords) : [],
            'tags' => $this->tags->pluck('tag'),
        ]);
    }

    public function shouldBeSearchable(): bool
    {
        return (bool) $this->live;
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            BlogTag::class,
            'blog_assigned_tags',
            'blog_id',
            'tag_id'
        )->withTimestamps();
    }

    protected function richTextType(): string
    {
        return 'NewsArticle';
    }

    protected function toRichText(): array
    {
        return [
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => 'https://www.coeliacsanctuary.co.uk',
            ],
            'headline' => $this->title,
            'image' => $this->main_image,
            'datePublished' => $this->created_at->format('c'),
            'dateModified' => $this->updated_at->format('c'),
            'author' => [
                '@type' => 'Person',
                'name' => 'Alison Wheatley',
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Coeliac Sanctuary',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => 'https://www.coeliacsanctuary.co.uk/assets/svg/logo.svg',
                ],
            ],
            'description' => $this->meta_description,
        ];
    }

    protected static function usesImages(): bool
    {
        return true;
    }

    protected function cacheKey(): string
    {
        return 'blogs';
    }

    protected static function dailyUpdateType(): array|int
    {
        return DailyUpdateType::BLOG_TAGS;
    }
}
