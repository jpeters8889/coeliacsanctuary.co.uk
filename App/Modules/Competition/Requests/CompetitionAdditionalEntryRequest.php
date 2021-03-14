<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Database\Query\Builder;
use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Competition\Rules\ValidEntryType;
use Coeliac\Modules\Competition\Models\CompetitionEntry;

class CompetitionAdditionalEntryRequest extends ApiFormRequest
{
    public function userHasAlreadyEnteredAdditionalType(CompetitionEntry $entry): bool
    {
        return $this->route('competition')
            ->entries()
            ->where('name', $entry->name)
            ->where('email', $entry->email)
            ->where('entry_type', $this->input('type'))
            ->exists();
    }

    public function getPrimaryEntry(): CompetitionEntry
    {
        return $this->route('competition')
            ->entries()
            ->firstWhere('id', $this->input('id'));
    }

    public function rules()
    {
        return [
            'id' => [
                'required',
                Rule::exists('competition_entries')
                    ->where(fn (Builder $query) => $query->where('competition_id', $this->route('competition')->id)
                        ->where('entry_type', 'primary')),
            ],
            'type' => [
                'required',
                Rule::in(['facebook_like', 'facebook_share', 'twitter_follow', 'twitter_tweet', 'shop_purchase']),
                new ValidEntryType($this->route('competition')),
            ],
        ];
    }
}
