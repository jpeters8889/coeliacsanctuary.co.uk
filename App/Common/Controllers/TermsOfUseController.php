<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;

class TermsOfUseController extends BaseController
{
    public function get(Page $page)
    {
        return $page
            ->breadcrumbs([], 'Terms of Use')
            ->setPageTitle('Terms of Use')
            ->render('pages.terms');
    }
}
