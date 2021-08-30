<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Http\Response;

class TermsOfUseController extends BaseController
{
    public function get(Page $page): Response
    {
        return $page
            ->breadcrumbs([], 'Terms of Use')
            ->setPageTitle('Terms of Use')
            ->render('pages.terms');
    }
}
