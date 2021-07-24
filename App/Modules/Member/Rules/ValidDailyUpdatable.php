<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Rules;

use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Requests\DailyUpdateSubscribeRequest;

class ValidDailyUpdatable implements Rule
{
    private DailyUpdateSubscribeRequest $request;

    public function __construct(DailyUpdateSubscribeRequest $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        /** @var DailyUpdateType $dailyUpdate */
        $dailyUpdate = DailyUpdateType::query()->find($this->request->input('type'));

        if (!$dailyUpdate) {
            return false;
        }

        $subscribable = $dailyUpdate->updatable_type;
        $prop = 'id';

        if ($dailyUpdate->id === DailyUpdateType::BLOG_TAGS) {
            $prop = 'slug';
        }

        return $subscribable::query()->where($prop, $value)->exists();
    }

    public function message()
    {
        return 'This updatable doesn\'t exist';
    }
}
