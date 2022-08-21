<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEat;

class WhereToEatSubmitReviewRequest extends ApiFormRequest
{
    public function resolveWhereToEat(): WhereToEat
    {
        /** @var WhereToEat $eatery */
        $eatery = WhereToEat::query()->findOrFail($this->route('id'));

        return $eatery;
    }

    protected function isNationwide(): bool
    {
        return $this->resolveWhereToEat()->county->county === 'Nationwide';
    }

    public function isReviewLive(): bool
    {
        if ($this->input('admin_review') === true && $this->user()?->isAdmin()) {
            return true;
        }

        $requiredFieldsCheck = $this->input('name') === null
            && $this->input('email') === null
            && $this->input('comment') === null;

        if ($this->isNationwide()) {
            return $this->input('branch_name') !== null && $requiredFieldsCheck;
        }

        return $requiredFieldsCheck;
    }

    public function rules(): array
    {
        return [
            'rating' => ['required', 'numeric', 'min:1', 'max:5'],
            'name' => ['nullable', 'required_with:email,comment'],
            'email' => ['nullable', 'required_with:name,comment', 'email'],
            'food' => ['nullable', 'in:poor,good,excellent'],
            'service' => ['nullable', 'in:poor,good,excellent'],
            'expense' => ['nullable', 'numeric', 'min:1', 'max:5'],
            'comment' => ['nullable', 'required_with:name,email'],
            'images' => ['array', 'max:6'],
            'images.*' => ['string', 'exists:temporary_file_uploads,id'],
            'method' => ['in:website,app'],
            'admin_review' => $this->user()?->isAdmin() ? ['boolean'] : ['sometimes', 'declined'],
            'branch_name' => $this->isNationwide() ? ['required_with:name,email,comment'] : ['prohibited'],
        ];
    }
}
