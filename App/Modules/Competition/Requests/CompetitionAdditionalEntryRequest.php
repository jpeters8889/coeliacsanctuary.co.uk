<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Competition\Models\Competition;
use Coeliac\Modules\Competition\Models\CompetitionEntry;
use Coeliac\Modules\Competition\Rules\ValidEntryType;
use Illuminate\Database\Query\Builder;
use Illuminate\Validation\Rule;

class CompetitionAdditionalEntryRequest extends ApiFormRequest
{
    public function userHasAlreadyEnteredAdditionalType(CompetitionEntry $entry): bool
    {
        /** @var Competition $competition */
        $competition = $this->route('competition');

        return $competition
            ->entries()
            ->where('name', $entry->name)
            ->where('email', $entry->email)
            ->where('entry_type', $this->input('type'))
            ->exists();
    }

    public function getPrimaryEntry(): CompetitionEntry
    {
        /** @var Competition $competition */
        $competition = $this->route('competition');

        return $competition
            ->entries()
            ->findOrFail($this->input('id'));
    }

    public function rules(): array
    {
        /** @var Competition $competition */
        $competition = $this->route('competition');

        return [
            'id' => [
                'required',
                Rule::exists('competition_entries')
                    ->where(fn (Builder $query) => $query->where('competition_id', $competition->id)
                    ->where('entry_type', 'primary')),
            ],
            'type' => [
                'required',
                Rule::in(['facebook_like', 'facebook_share', 'twitter_follow', 'twitter_tweet', 'shop_purchase']),
                new ValidEntryType($competition),
            ],
        ];
    }
}
