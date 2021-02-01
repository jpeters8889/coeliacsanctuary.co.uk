<?php

namespace Coeliac\Modules\Member\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Response\Page;
use Coeliac\Modules\Member\Requests\LoginRequest;
use Illuminate\Http\Response;

class LoginController extends BaseController
{
    public function show(Page $page): Response
    {
        return $page->breadcrumbs([], 'Member Login')
            ->doNotIndex()
            ->setPageTitle('Member Login')
            ->render('modules.member.login');
    }

    public function create(LoginRequest $request)
    {
        //
    }
}
