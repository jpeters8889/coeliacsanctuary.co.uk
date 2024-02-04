<?php

declare(strict_types=1);

namespace Coeliac\Architect\Plans\CompetitionEntries;

use Illuminate\Http\Request;
use Coeliac\Modules\Competition\Models\Competition;

class ApiHandler
{
    public function get(Request $request, $id)
    {
        /** @var Competition $competition */
        $competition = Competition::query()->findOrFail($id);

        $hasMoreEntries = collect($competition->only([
                'enable_facebook_like',
                'enable_facebook_share',
                'enable_twitter_follow',
                'enable_twitter_tweet',
                'enable_shop_purchase',
            ]))->reject(fn ($value) => (bool) $value === false)
                ->values()
                ->count() > 1;

        return [
            'total_entries' => $competition->entries()->count(),
            'has_more_entries' => $hasMoreEntries,
            'primary' => $competition->entries()->where('entry_type', 'primary')->count(),
            'facebook_like' => $competition->entries()->where('entry_type', 'facebook_like')->count(),
            'facebook_share' => $competition->entries()->where('entry_type', 'facebook_share')->count(),
            'twitter_follow' => $competition->entries()->where('entry_type', 'twitter_follow')->count(),
            'twitter_tweet' => $competition->entries()->where('entry_type', 'twitter_tweet')->count(),
            'facebook_pho_like' => $competition->entries()->where('entry_type', 'facebook_pho')->count(),
            'shop_purchase' => $competition->entries()->where('entry_type', 'shop_purchase')->count(),
            'entrants' => $competition->entries()->latest()->paginate(25, '*', 'page', $request->get('page', 1)),
        ];
    }
}
