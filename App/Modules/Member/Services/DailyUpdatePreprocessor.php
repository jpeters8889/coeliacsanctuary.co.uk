<?php

namespace Coeliac\Modules\Member\Services;

use Illuminate\Database\Eloquent\Collection;

class DailyUpdatePreprocessor
{
    private Collection $updates;

    public function __construct(Collection $updates)
    {
        $this->updates = $updates;
    }


}
