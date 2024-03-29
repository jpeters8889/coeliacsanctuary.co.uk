<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Services;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatTown;
use Illuminate\Support\Collection;

class DailyUpdatePreprocessor
{
    protected ?Collection $blogs = null;
    protected ?Collection $eateries = null;

    public function __construct(protected Collection $subscriptions, protected Collection $updates)
    {
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
        $this->updates->each(function (Blog|WhereToEat $item) {
            if (! $item->live) {
                return;
            }

            if ($item instanceof Blog) {
                $this->processBlog($item);

                return;
            }

            $this->processEatery($item);
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
        if (! $this->blogs) {
            $this->blogs = new Collection([
                'items' => new Collection(),
                'subscriptions' => new Collection(),
            ]);
        }
    }

    protected function bootstrapEateries(): void
    {
        if (! $this->eateries) {
            $this->eateries = new Collection([
                'items' => new Collection(),
                'subscriptions' => new Collection(),
            ]);
        }
    }

    protected function blogAlreadyProcessed(Blog $blog): bool
    {
        return $this->blogs?->get('items')->contains(fn ($item) => $item['id'] === $blog->id);
    }

    protected function eateryAlreadyProcessed(WhereToEat $eatery): bool
    {
        return $this->eateries?->get('items')->contains(fn ($item) => $item['id'] === $eatery->id);
    }

    protected function processBlogTag(Blog $blog): void
    {
        $this->subscriptions->map(function ($tag) use ($blog) {
            if (! $tag instanceof BlogTag) {
                return;
            }

            if ($blog->tags()->where('id', $tag->id)->count() === 0) {
                return;
            }

            if ($this->blogs?->get('subscriptions')->contains($tag->tag)) {
                return;
            }

            $this->blogs?->get('subscriptions')->push($tag->tag);
        });
    }

    protected function processWhereToEatUpdatable(WhereToEat $eatery): void
    {
        $this->subscriptions->map(function ($subscription) use ($eatery) {
            if (! $subscription || $subscription instanceof BlogTag) {
                return;
            }

            $check = 'county_id';
            $attribute = 'county';

            if ($subscription instanceof WhereToEatTown) {
                $check = 'town_id';
                $attribute = 'town';
            }

            if ((int)$eatery->$check !== $subscription->id) {
                return;
            }

            if ($this->eateries?->get('subscriptions')->contains($subscription->$attribute)) {
                return;
            }

            $this->eateries?->get('subscriptions')->push($subscription->$attribute);
        });
    }

    protected function pushEatery(WhereToEat $eatery): void
    {
        $eatery->load(['country', 'county', 'town']);

        $this->eateries?->get('items')->push([
            'id' => $eatery->id,
            'title' => $eatery->name,
            'location' => $eatery->full_location,
            'link' => '/wheretoeat/' . $eatery->county->slug . '/', $eatery->town->slug,
            'description' => $eatery->info,
            'address' => str_replace('<br />', ', ', $eatery->address),
        ]);
    }

    protected function pushBlog(Blog $blog): void
    {
        $blog->load('images');

        $this->blogs?->get('items')->push([
            'id' => $blog->id,
            'title' => $blog->title,
            'link' => $blog->link,
            'description' => $blog->meta_description,
            'image' => $blog->main_image,
        ]);
    }
}
