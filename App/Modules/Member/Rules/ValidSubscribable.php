<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Rules;

use Coeliac\Modules\Member\Models\SubscriptionType;
use Illuminate\Contracts\Validation\Rule;
use Coeliac\Modules\Member\Requests\CreateSubscriptionRequest;

class ValidSubscribable implements Rule
{
    private CreateSubscriptionRequest $request;

    public function __construct(CreateSubscriptionRequest $request)
    {
        $this->request = $request;
    }

    public function passes($attribute, $value)
    {
        /** @var SubscriptionType $subscriptionType */
        $subscriptionType = SubscriptionType::query()->find($this->request->input('type'));

        if (!$subscriptionType) {
            return false;
        }

        $subscribable = $subscriptionType->subscribable_type;
        $prop = 'id';

        if ($subscriptionType->id === SubscriptionType::BLOG_TAGS) {
            $prop = 'tag';
        }

        return $subscribable::query()->where($prop, $value)->exists();
    }

    public function message()
    {
        return 'This subscribable doesn\'t exist';
    }
}
