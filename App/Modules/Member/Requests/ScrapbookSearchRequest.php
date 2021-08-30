<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use RuntimeException;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Recipe\Models\Recipe;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class ScrapbookSearchRequest extends ApiFormRequest
{
    public function resolveItem(): string
    {
        switch ($this->input('area')) {
            case 'blog':
                return Blog::class;
            case 'review':
                return Review::class;
            case 'recipe':
                return Recipe::class;
        }

        throw new RuntimeException('Unknown Area');
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric'],
            'area' => ['required', 'in:blog,recipe,review'],
        ];
    }
}
