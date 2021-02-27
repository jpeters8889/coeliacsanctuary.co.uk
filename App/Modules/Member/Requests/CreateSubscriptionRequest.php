<?php

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Member\Contracts\Subscribable;
use Coeliac\Modules\Member\Models\SubscriptionType;
use Coeliac\Modules\Member\Rules\ValidSubscribable;

class CreateSubscriptionRequest extends ApiFormRequest
{
    protected ?SubscriptionType $subscription = null;

    public function rules()
    {
        return [
            'type' => ['required', 'numeric', 'exists:user_subscription_types,id'],
            'subscribable' => ['required', new ValidSubscribable($this)],
        ];
    }

    public function subscription(): SubscriptionType
    {
        if (!$this->subscription) {
            $this->subscription = SubscriptionType::query()->find($this->input('type'));
        }

        return $this->subscription;
    }

    public function subscribable(): Subscribable
    {
        $subscribable = $this->subscription->subscribable_type;
        $prop = 'id';

        if ($this->input('type') === SubscriptionType::BLOG_TAGS) {
            $prop = 'tag';
        }

        return $subscribable::query()->firstWhere($prop, $this->input('subscribable'));
    }
}
