<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Events;

use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Models\DailyUpdateType;

class DailyUpdateItemCreated
{
    protected ?DailyUpdateType $dailyUpdateType = null;

    public function __construct(protected BaseModel $model, protected int $dailyUpdateTypeId)
    {
    }

    public function model(): BaseModel
    {
        return $this->model;
    }

    public function dailyUpdateType(): DailyUpdateType
    {
        if (!$this->dailyUpdateType) {
            $this->dailyUpdateType = DailyUpdateType::query()->findOrFail($this->dailyUpdateTypeId);
        }

        return $this->dailyUpdateType;
    }
}
