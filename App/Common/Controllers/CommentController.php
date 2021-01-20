<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Common\Requests\CommentRequest;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class CommentController extends BaseController
{
    public function store(CommentRequest $request)
    {
        $request->model()->comments()->create($request->only(['name', 'email', 'comment']));

        return ['data' => 'Comment Created'];
    }

    public function get($area, $id)
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

        return $model::query()
            ->where('live', 1)
            ->where('id', $id)
            ->first()
            ->comments()
            ->latest()
            ->with('reply')
            ->where('approved', 1)
            ->paginate(5);
    }
}
