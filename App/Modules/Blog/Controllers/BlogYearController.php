<?php

declare(strict_types=1);

namespace Coeliac\Modules\Blog\Controllers;

use Coeliac\Modules\Blog\Repository;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Database\Eloquent\Collection;

class BlogYearController extends BaseController
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function list()
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
