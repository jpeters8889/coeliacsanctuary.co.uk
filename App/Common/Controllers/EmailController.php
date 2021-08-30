<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Common\Requests\EmailRequest;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\MjmlCompiler\CompilerContract;
use Coeliac\Common\Notifications\Messages\MJMLMessage;

class EmailController extends BaseController
{
    public function get(EmailRequest $request, CompilerContract $compiler): string
    {
        $email = $request->email();

        $data = $email->data;

        $email = (new MJMLMessage())->mjml($email->template, $data);

        return $compiler->compile($email->render())['html'];
    }
}
