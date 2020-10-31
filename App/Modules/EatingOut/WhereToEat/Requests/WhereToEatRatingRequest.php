<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatRatingRequest extends ApiFormRequest
{
    public function resolveWhereToEat(): WhereToEat
    {
        return WhereToEat::query()->findOrFail($this->route('id'));
    }

    public function isReviewLive(): bool
    {
        return $this->input('name') === null && $this->input('email') === null && $this->input('comment') === null;
    }

    public function rules()
    {
        return [
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'name' => ['nullable', 'required_with:email,comment'],
            'email' => ['nullable', 'required_with:name,comment', 'email'],
            'comment' => ['nullable', 'required_with:name,email'],
            'method' => ['in:website,app'],
        ];
    }
}
