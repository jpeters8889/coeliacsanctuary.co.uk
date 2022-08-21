<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Illuminate\Http\Response;

class PrivacyPolicyController extends BaseController
{
    public function get(Page $page): Response
    {
        return $page
            ->breadcrumbs([], 'Privacy Policy')
            ->setPageTitle('Privacy Policy')
            ->render('pages.privacy');
    }
}
