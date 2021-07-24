<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Services;

use Illuminate\Support\Str;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Support\Collection;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;

class DailyUpdatePreprocessor
{
    protected Collection $subscriptions;
    protected Collection $updates;

    protected ?Collection $blogs = null;
    protected ?Collection $eateries = null;

    public function __construct(Collection $subscription, Collection $updates)
    {
        $this->subscriptions = $subscription;
        $this->updates = $updates;
    }

    public function process(): Collection
    {
        $this->parseUpdates();

        return new Collection([
            'blogs' => $this->blogs,
            'eateries' => $this->eateries,
        ]);
    }

    protected function parseUpdates(): void
    {
        $this->updates->each(function (BaseModel $item) {
            if (!$item->live) {
                return;
            }

            switch (Str::lower(class_basename($item))) {
                case 'blog':
                    /* @var Blog $item */
                    $this->processBlog($item);
                    break;
                case 'wheretoeat':
                    /* @var WhereToEat $item */
                    $this->processEatery($item);
                    break;
            }
        });
    }

    protected function processEatery(WhereToEat $eatery): void
    {
        $this->bootstrapEateries();

        if ($this->eateryAlreadyProcessed($eatery)) {
            return;
        }

        $this->pushEatery($eatery);
        $this->processWhereToEatUpdatable($eatery);
    }

    protected function processBlog(Blog $blog): void
    {
        $this->bootstrapBlogs();

        if ($this->blogAlreadyProcessed($blog)) {
            return;
        }

        $this->pushBlog($blog);
        $this->processBlogTag($blog);
    }

    protected function bootstrapBlogs(): void
    {
        if (!$this->blogs) {
            $this->blogs = new Collection([
                'items' => new Collection(),
                'subscriptions' => new Collection(),
            ]);
        }
    }

    protected function bootstrapEateries(): void
    {
        if (!$this->eateries) {
            $this->eateries = new Collection([
                'items' => new Collection(),
                'subscriptions' => new Collection(),
            ]);
        }
    }

    protected function blogAlreadyProcessed(Blog $blog): bool
    {
        return $this->blogs->get('items')->contains(fn ($item) => $item['id'] === $blog->id);
    }

    protected function eateryAlreadyProcessed(WhereToEat $eatery): bool
    {
        return $this->eateries->get('items')->contains(fn ($item) => $item['id'] === $eatery->id);
    }

    protected function processBlogTag(Blog $blog): void
    {
        $this->subscriptions->map(function ($tag) use ($blog) {
            if (!$tag instanceof BlogTag) {
                return;
            }

            if (!$blog->tags()->get()->contains(fn ($blogTag) => $blogTag->id === $tag->id)) {
                return;
            }

            if ($this->blogs->get('subscriptions')->contains($tag->tag)) {
                return;
            }

            $this->blogs->get('subscriptions')->push($tag->tag);
        });
    }

    protected function processWhereToEatUpdatable(WhereToEat $eatery): void
    {
        $this->subscriptions->map(function ($subscription) use ($eatery) {
            if ($subscription instanceof BlogTag) {
                return;
            }

            $check = 'county_id';
            $attribute = 'county';

            if ($subscription instanceof WhereToEatTown) {
                $check = 'town_id';
                $attribute = 'town';
            }

            if ((int) $eatery->$check !== $subscription->id) {
                return;
            }

            if ($this->eateries->get('subscriptions')->contains($subscription->$attribute)) {
                return;
            }

            $this->eateries->get('subscriptions')->push($subscription->$attribute);
        });
    }

    protected function pushEatery(WhereToEat $eatery): void
    {
        $this->eateries->get('items')->push([
            'id' => $eatery->id,
            'title' => $eatery->name,
            'location' => $eatery->full_location,
            'link' => '/wheretoeat/'.$eatery->county->slug.'/', $eatery->town->slug,
            'description' => $eatery->info,
            'address' => str_replace('<br />', ', ', $eatery->address),
        ]);
    }

    protected function pushBlog(Blog $blog): void
    {
        $this->blogs->get('items')->push([
            'id' => $blog->id,
            'title' => $blog->title,
            'link' => $blog->link,
            'description' => $blog->meta_description,
            'image' => $blog->main_image,
        ]);
    }
}
