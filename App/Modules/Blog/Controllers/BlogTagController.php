<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Blog\Repository;
use Illuminate\Support\Collection;

class BlogTagController extends BaseController
{
    public function __construct(private Repository $repository)
    {
    }

    public function list(): array
    {
        $tags = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->each(function (Blog $blog) use (&$tags) {
                $blog->tags->each(function (BlogTag $tag) use ($blog, &$tags) {
                    if (isset($tags[$tag->id])) {
                        $tags[$tag->id]['blogs']->push($blog->id);

                        return;
                    }

                    $tags[$tag->id] = new Collection([
                        'title' => $tag->tag,
                        'slug' => $tag->slug,
                        'blogs' => new Collection([$blog->id]),
                    ]);
                });
            });

        return [
            'data' => $tags->map(static function ($tag) {
                return [
                    'slug' => $tag['slug'],
                    'title' => $tag['title'],
                    'blogs_count' => $tag['blogs']->count(),
                ];
            })->sortByDesc('blogs_count')
                ->values(),
        ];
    }
}
