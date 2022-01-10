<?php

namespace Coeliac\Common\Controllers;

use Carbon\Carbon;
use Coeliac\Common\Feed\CombinedFeed;
use Coeliac\Modules\Blog\Repository as BlogRepository;
use Coeliac\Modules\EatingOut\Reviews\Repository as ReviewRepository;
use Coeliac\Modules\Recipe\Repository as RecipeRepository;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class FeedController
{
    public function __invoke(CombinedFeed $feed, CacheRepository $cacheRepository)
    {
        return $cacheRepository->remember(
            'feed',
            Carbon::now()->addHour(),
            function () use ($feed) {
                $columns = ['id', 'title', 'slug', 'meta_description', 'created_at'];

                $blogs = resolve(BlogRepository::class)->setColumns($columns)->take(10);
                $reviews = resolve(ReviewRepository::class)->setColumns($columns)->take(10);
                $recipes = resolve(RecipeRepository::class)->setColumns($columns)->take(10);

                $combined = (new Collection([
                    ...$blogs,
                    ...$reviews,
                    ...$recipes
                ]))->sortByDesc('created_at');

                return new Response(
                    $feed->render($combined->take(10)),
                    200,
                    ['Content-type' => 'text/xml'],
                );
            }
        );
    }
}
