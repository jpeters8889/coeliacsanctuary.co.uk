<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\MjmlCompiler\CompilerContract;
use Coeliac\Common\Notifications\Messages\MJMLMessage;
use Coeliac\Common\Requests\EmailRequest;
use Illuminate\Support\HtmlString;

class EmailController extends BaseController
{
    public function get(EmailRequest $request, CompilerContract $compiler): string|HtmlString
    {
        $email = $request->email();

        $data = $email->data;

        $email = (new MJMLMessage())->mjml($email->template, $data);

        return $compiler->compile((string) $email->render())['html'];
    }
}
