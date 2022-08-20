<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Requests\CommentRequest;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Pagination\LengthAwarePaginator;

class CommentController extends BaseController
{
    public function store(CommentRequest $request): array
    {
        $request->model()->comments()->create($request->only(['name', 'email', 'comment']));

        return ['data' => 'Comment Created'];
    }

    public function get(string $area, mixed $id): LengthAwarePaginator
    {
        switch ($area) {
            case 'blog':
                $model = Blog::class;

                break;
            case 'recipe':
                $model = Recipe::class;

                break;
            case 'review':
                $model = Review::class;

                break;
            default:
                abort(404);
        }

        /** @phpstan-ignore-next-line  */
        return $model::query()
            ->where('live', 1)
            ->where('id', $id)
            ->first()
            ?->comments()
            ->latest()
            ->with('reply')
            ->where('approved', 1)
            ->paginate(5);
    }
}
