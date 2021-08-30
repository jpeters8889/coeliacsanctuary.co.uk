<?php

declare(strict_types=1);

namespace Coeliac\Common\Controllers;

use Exception;
use Illuminate\Http\Response;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Common\Newsletter\NewsletterService;
use Coeliac\Common\Requests\NewsletterSignupRequest;
use Coeliac\Common\Newsletter\Exceptions\AlreadySubscribedException;

class NewsletterController extends BaseController
{
    public function store(NewsletterSignupRequest $request, NewsletterService $newsletterService): Response
    {
        try {
            $newsletterService->subscribe($request->input('email'), $request->input('url'));

            $response = [['data' => 'ok'], 200];
        } catch (AlreadySubscribedException $exception) {
            $response = [['error' => 'already-subscribed'], 409];
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);
            $response = [['error' => ''], 400];
        }

        return new Response(...$response);
    }
}
