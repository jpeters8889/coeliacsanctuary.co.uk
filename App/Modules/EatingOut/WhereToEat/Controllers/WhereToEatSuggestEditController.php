<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\GetEatery;
use Coeliac\Modules\EatingOut\WhereToEat\SuggestEdits\UpdateHandler;

class WhereToEatSuggestEditController extends BaseController
{
    public function get(GetEatery $eatery, int $id): array
    {
        return [
            'data' => $eatery->formatData($id),
        ];
    }

    public function update(UpdateHandler $updateHandler)
    {
        $updateHandler->process();
    }
}
