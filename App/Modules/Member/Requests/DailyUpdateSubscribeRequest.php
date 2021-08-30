<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Requests;

use Coeliac\Base\Requests\ApiFormRequest;
use Coeliac\Modules\Member\Contracts\Updatable;
use Coeliac\Modules\Member\Models\DailyUpdateType;
use Coeliac\Modules\Member\Rules\ValidDailyUpdatable;

class DailyUpdateSubscribeRequest extends ApiFormRequest
{
    protected ?DailyUpdateType $dailyUpdate = null;

    public function rules(): array
    {
        return [
            'type' => ['required', 'numeric', 'exists:daily_update_types,id'],
            'updatable' => ['required', new ValidDailyUpdatable($this)],
        ];
    }

    public function dailyUpdate(): DailyUpdateType
    {
        if (!$this->dailyUpdate) {
            /** @phpstan-ignore-next-line  */
            $this->dailyUpdate = DailyUpdateType::query()->findOrFail($this->input('type'));
        }

        /** @phpstan-ignore-next-line  */
        return $this->dailyUpdate;
    }

    public function updatable(): ?Updatable
    {
        if (!$this->dailyUpdate() instanceof DailyUpdateType) {
            return null;
        }

        $subscribable = $this->dailyUpdate()->updatable_type;
        $prop = 'id';

        if ($this->input('type') === DailyUpdateType::BLOG_TAGS) {
            $prop = 'slug';
        }

        return $subscribable::query()->firstWhere($prop, $this->input('updatable'));
    }
}
