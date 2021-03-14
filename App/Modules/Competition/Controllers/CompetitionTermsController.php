<?php

declare(strict_types=1);

namespace Coeliac\Modules\Competition\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Competition\Models\Competition;

class CompetitionTermsController extends BaseController
{
    public function __invoke(Competition $competition)
    {
        return $competition->terms;
    }
}
