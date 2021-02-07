<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Payment;

use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Coeliac\Modules\Member\Models\User;
use Coeliac\Modules\Shop\Basket\Basket;
use Illuminate\Contracts\Events\Dispatcher;
use Coeliac\Modules\Shop\Events\CreateOrder;
use Coeliac\Modules\Shop\Requests\OrderRequest;
use Coeliac\Modules\Shop\Exceptions\PaymentException;

abstract class Processor
{
    protected Basket $basket;
    protected Provider $paymentProvider;
    protected OrderRequest $request;

    public function __construct(Basket $basket, Provider $paymentProvider)
    {
        $this->basket = $basket;
        $this->paymentProvider = $paymentProvider;
    }

    abstract public function initiatePayment();

    abstract public function processPayment(Request $request);

    public function processRequest(OrderRequest $request)
    {
        if (!$this->basket->resolve()) {
            throw new PaymentException('no basket');
        }

        if ($this->basket->model()->items()->count() === 0) {
            throw new PaymentException('no items');
        }

        $this->request = $request;

        $user = User::query()->firstOrCreate(
            ['email' => $this->request->input('user.email')],
            [
                'name' => $this->request->input('user.name'),
                'phone' => $this->request->input('user.phone'),
            ],
            );

        $this->basket->model()->user_id = $user->id;
        $this->processAddresses($user);
        $this->basket->model()->save();
    }

    protected function processAddresses(User $user)
    {
        $address = $user->addresses()->firstOrCreate([
            'type' => 'Shipping',
            'name' => $this->request->input('user.name'),
            'line_1' => $this->request->input('shipping.address1'),
            'line_2' => $this->request->input('shipping.address2'),
            'line_3' => $this->request->input('shipping.address3'),
            'town' => $this->request->input('shipping.town'),
            'postcode' => $this->request->input('shipping.postcode'),
            'country' => $this->basket->model()->postageCountry->country,
        ]);

        $user->addresses()->firstOrCreate([
            'type' => 'Billing',
            'name' => $this->request->input('billing.name'),
            'line_1' => $this->request->input('billing.address1'),
            'line_2' => $this->request->input('billing.address2'),
            'line_3' => $this->request->input('billing.address3'),
            'town' => $this->request->input('billing.town'),
            'postcode' => $this->request->input('billing.postcode'),
            'country' => $this->request->input('billing.country'),
        ]);

        $this->basket->model()->user_address_id = $address->id;
    }

    protected function submitOrderCompleteEvent($provider, $data)
    {
        Container::getInstance()->make(Dispatcher::class)->dispatch(
            new CreateOrder(
                $this->basket->model(),
                $this->basket->postage()->calculate(),
                $provider,
                $data,
                $this->basket->discount(),
            )
        );
    }
}
