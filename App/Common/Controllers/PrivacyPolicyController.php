<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class PrivacyPolicyController extends BaseController
{
    public function get(Page $page)
    {
        return $page
            ->breadcrumbs([], 'Privacy Policy')
            ->setPageTitle('Privacy Policy')
            ->render('pages.privacy');
    }
}
