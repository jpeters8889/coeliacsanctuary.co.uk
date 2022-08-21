<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Exceptions\PaymentException;
use Coeliac\Modules\Shop\Payment\Processor as PaymentProcessor;
use Coeliac\Modules\Shop\Requests\OrderRequest;
use Coeliac\Modules\Shop\Requests\OrderUpdateRequest;
use Exception;
use Illuminate\Http\Response;

class OrderController extends BaseController
{
    public function __construct(private PaymentProcessor $paymentProcessor)
    {
    }

    public function create(OrderRequest $request): mixed
    {
        try {
            $this->paymentProcessor->processRequest($request);

            return $this->paymentProcessor->initiatePayment();
        } catch (PaymentException $exception) {
            Bugsnag::notifyException($exception);

            return new Response(['error' => $exception->getMessage()], 400);
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);

            return new Response(['error' => 'An unknown error occurred'], 400);
        }
    }

    public function update(OrderUpdateRequest $request): mixed
    {
        try {
            return $this->paymentProcessor->processPayment($request);
        } catch (PaymentException $exception) {
            Bugsnag::notifyException($exception);

            return new Response(['error' => $exception->getMessage()], 400);
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);

            return new Response(['error' => 'An unknown error occurred'], 400);
        }
    }
}
