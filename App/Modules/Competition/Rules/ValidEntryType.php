<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Rules;

use Coeliac\Modules\Competition\Models\Competition;
use Illuminate\Contracts\Validation\Rule;

class ValidEntryType implements Rule
{
    private Competition $competition;

    public function __construct(Competition $competition)
    {
        $this->competition = $competition;
    }

    public function passes($attribute, $value)
    {
        if ($value === 'facebook_pho') {
            return true;
        }

        $map = [
          'facebook_like' => 'enable_facebook_like',
          'facebook_share' => 'enable_facebook_share',
          'twitter_follow' => 'enable_twitter_follow',
          'twitter_tweet' => 'enable_twitter_tweet',
          'shop_purchase' => 'enable_shop_purchase',
        ];

        if (! array_key_exists($value, $map)) {
            return false;
        }

        return (bool) $this->competition->{$map[$value]};
    }

    public function message()
    {
        return 'Not a valid entry type';
    }
}
