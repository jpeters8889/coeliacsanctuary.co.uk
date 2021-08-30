<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Competition\Models\Competition;

class CompetitionInitialEntryRequest extends ApiFormRequest
{
    public function userHasAlreadyEntered(): bool
    {
        /** @var Competition $competition */
        $competition = $this->route('competition');

        return $competition
            ->entries()
            ->where('name', $this->input('name'))
            ->where('email', $this->input('email'))
            ->exists();
    }

    public function rules(): array
    {
        return [
            'name' => ['required'],
            'email' => ['required', 'email'],
        ];
    }
}
