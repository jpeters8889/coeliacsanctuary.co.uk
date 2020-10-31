<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class CookiePolicyController extends BaseController
{
    public function get(Page $page)
    {
        return $page
            ->breadcrumbs([], 'Cookie Policy')
            ->setPageTitle('Cookie Policy')
            ->render('pages.cookie');
    }
}
