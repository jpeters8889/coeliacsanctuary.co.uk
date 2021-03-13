<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Requests;

use Coeliac\Base\Requests\ApiFormRequest;

class CompetitionInitialEntryRequest extends ApiFormRequest
{
    public function userHasAlreadyEntered(): bool
    {
        return $this->route('competition')
            ->entries()
            ->where('name', $this->input('name'))
            ->where('email', $this->input('email'))
            ->exists();
    }

    public function rules()
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ];
    }
}
