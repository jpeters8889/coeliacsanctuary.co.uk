<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Blog\DTOs\BlogRelationCount;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Models\BlogTag;
use Coeliac\Modules\Blog\Repository;
use Illuminate\Support\Collection;

class BlogTagController extends BaseController
{
    public function __construct(protected Repository $repository)
    {
    }

    public function list(): array
    {
        /** @var Collection<int,BlogRelationCount> $tags */
        $tags = new Collection();

        $this->repository
            ->search()
            ->filter()
            ->setColumns(['id'])
            ->all()
            ->each(fn (Blog $blog) => $blog->tags->each(function (BlogTag $tag) use ($blog, &$tags) {
                if ($tags->where('id', $tag->id)->count() > 0) {
                    $tags->firstWhere('id', $tag->id)->blogs->push($blog->id);

                    return;
                }

                $tags->push(new BlogRelationCount([
                    'id' => $tag->id,
                    'title' => $tag->tag,
                    'slug' => $tag->slug,
                    'blogs' => new Collection([$blog->id]),
                ]));
            }));

        return [
            'data' => $tags->map(fn (BlogRelationCount $tag) => [
                'slug' => $tag->slug,
                'title' => $tag->title,
                'blogs_count' => $tag->blogs->count(),
            ])->sortByDesc('blogs_count')->values(),
        ];
    }
}
