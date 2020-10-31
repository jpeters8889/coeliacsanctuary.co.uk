<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\EatingOut\WhereToEat\MapSettings;

class WhereToEatSettingsController extends BaseController
{
    public function get(MapSettings $mapSettings)
    {
        return $mapSettings->getSettings();
    }
}
