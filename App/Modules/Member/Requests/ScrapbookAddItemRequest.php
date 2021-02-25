<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use RuntimeException;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Blog\Models\Blog;
use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Recipe\Models\Recipe;
use Illuminate\Contracts\Auth\Access\Gate;
use Coeliac\Modules\EatingOut\Reviews\Models\Review;

class ScrapbookAddItemRequest extends ApiFormRequest
{
    public function authorize(Gate $gate)
    {
        return $gate->allows('manage-scrapbook', $this->route('scrapbook'));
    }

    public function resolveItem(): BaseModel
    {
        switch ($this->input('type')) {
            case 'blog':
                $builder = Blog::query();
                break;
            case 'review':
                $builder = Review::query();
                break;
            case 'recipe':
                $builder = Recipe::query();
                break;
            default:
                throw new RuntimeException('Unexpected value');
        }

        return $builder->where('live', 1)->findOrFail($this->input('id'));
    }

    public function rules()
    {
        return [
            'id' => ['required', 'numeric'],
            'type' => ['required', 'in:blog,recipe,review'],
        ];
    }
}
