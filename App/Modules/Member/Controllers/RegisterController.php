<?php

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Illuminate\Http\Response;

class RegisterController extends BaseController
{
    public function show(Page $page): Response
    {
        return $page->breadcrumbs([], 'Register')
            ->doNotIndex()
            ->setPageTitle('Register')
            ->render('modules.member.register');
    }
}
