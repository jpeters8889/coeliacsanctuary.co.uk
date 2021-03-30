<?php

declare(strict_types=1);

namespace Coeliac\Modules\Member\Controllers;

use Illuminate\Http\Response;
use Coeliac\Base\Controllers\BaseController;
use Illuminate\Contracts\Auth\PasswordBroker;
use Coeliac\Modules\Member\Requests\CreateForgotPasswordRequest;

class ForgotPasswordController extends BaseController
{
    public function create(CreateForgotPasswordRequest $request, PasswordBroker $passwordBroker)
    {
        $status = $passwordBroker->sendResetLink($request->validated());

        if ($status === $passwordBroker::RESET_LINK_SENT) {
            return ['status' => 'reset_link_sent'];
        }

        return new Response(['status' => 'error'], 400);
    }
}
