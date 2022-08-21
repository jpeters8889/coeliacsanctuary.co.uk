<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Contracts\Auth\Access\Gate;
use RuntimeException;

class ScrapbookAddItemRequest extends ApiFormRequest
{
    public function authorize(Gate $gate): bool
    {
        return $gate->allows('manage-scrapbook', $this->route('scrapbook'));
    }

    public function resolveItem(): Blog|Review|Recipe
    {
        $builder = match ($this->input('type')) {
            'blog' => Blog::query(),
            'review' => Review::query(),
            'recipe' => Recipe::query(),
            default => throw new RuntimeException('Unexpected value'),
        };

        return $builder->where('live', 1)->findOrFail($this->input('id'));
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric'],
            'type' => ['required', 'in:blog,recipe,review'],
        ];
    }
}
