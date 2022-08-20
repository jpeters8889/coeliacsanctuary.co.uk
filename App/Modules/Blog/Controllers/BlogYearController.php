<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Blog\Repository;
use Illuminate\Database\Eloquent\Collection;

class BlogYearController extends BaseController
{
    public function __construct(private Repository $repository)
    {
    }

    public function list(): array
    {
        return [
            'data' => $this->repository
                ->setWiths([])
                ->filter()
                ->search()
                ->setColumns(['id', 'created_at'])
                ->all()
                ->groupBy(static function (Blog $blog) {
                    return $blog->created_at->format('Y');
                })
                ->sortKeys(SORT_REGULAR, true)
                ->transform(static function (Collection $blogs, $year) {
                    return [
                        'year' => $year,
                        'blogs_count' => $blogs->count(),
                    ];
                })
                ->values(),
        ];
    }
}
