<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class SiteMapController extends BaseController
{
    public function get(Page $page)
    {
        return $page
            ->breadcrumbs([], 'Site Map')
            ->setPageTitle('Site Map')
            ->render('pages.sitemap', [
            ]);
    }
}
