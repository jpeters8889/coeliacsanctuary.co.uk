<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Illuminate\Http\Response;

class CookiePolicyController extends BaseController
{
    public function get(Page $page): Response
    {
        return $page
            ->breadcrumbs([], 'Cookie Policy')
            ->setPageTitle('Cookie Policy')
            ->render('pages.cookie');
    }
}
