<?php

declare(strict_types=1);

namespace Coeliac\Common\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Common\Contracts\HasComments;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Recipe\Models\Recipe;

class CommentRequest extends ApiFormRequest
{
    public function model(): HasComments
    {
        /** @var class-string<HasComments> $models */
        $models = [
            'blog' => Blog::class,
            'recipe' => Recipe::class,
            'review' => Review::class,
        ];

        return $models[$this->input('area')]::query()->findOrFail($this->input('id'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'comment' => 'required',
            'id' => 'required|numeric',
            'area' => 'required|in:blog,recipe,review',
        ];
    }
}
