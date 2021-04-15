<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Http\Response;
use Coeliac\Common\Response\Page;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Member\Models\UserLevel;
use Illuminate\Contracts\Auth\PasswordBroker;
use Coeliac\Modules\Member\Requests\CreateForgotPasswordRequest;

class ForgotPasswordController extends BaseController
{
    public function show(Page $page)
    {
        return $page->doNotIndex()
            ->breadcrumbs([], 'Forgot Password')
            ->setPageTitle('Forgot Password')
            ->render('modules.member.forgot-password');
    }

    public function create(CreateForgotPasswordRequest $request, PasswordBroker $passwordBroker)
    {
        $status = $passwordBroker->sendResetLink(array_merge($request->validated(), [
            'user_level_id' => [UserLevel::MEMBER, UserLevel::ADMIN],
        ]));

        if ($status === $passwordBroker::RESET_LINK_SENT) {
            return ['status' => 'reset_link_sent'];
        }

        return new Response(['status' => 'error'], 400);
    }
}
