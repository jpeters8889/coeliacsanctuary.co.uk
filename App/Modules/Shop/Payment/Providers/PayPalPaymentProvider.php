<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Payment\Providers;

use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Payment\Provider;
use Illuminate\Container\Container;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ShippingAddress;
use PayPal\Api\Transaction;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext as PaypalApiContext;

class PayPalPaymentProvider implements Provider
{
    private float $total;
    private float $postage;
    private Payer $payer;
    private float $discount;
    private float $subtotal;
    private Amount $amount;
    private ?Basket $basket;
    private Details $details;
    private Payment $payment;
    private ItemList $itemList;
    private Transaction $transaction;
    private RedirectUrls $redirectUrls;
    private PaypalApiContext $paypalContext;

    public function __construct(PaypalApiContext $paypalContext)
    {
        $this->paypalContext = $paypalContext;

        if (Container::getInstance()->make(Repository::class)->get('app.env') === 'production') {
            $this->paypalContext->setConfig(['mode' => 'live']);
        }
    }

    public function initiatePayment(mixed $params): PayPalModel|array
    {
        $this->basket = resolve(Basket::class);

        $subtotal = (float) $this->basket->subtotal() / 100;
        $this->postage = (float) ($this->basket->postage()->calculate() / 100);
        $this->discount = ($this->basket->discount() ? (float) $this->basket->discount()?->calculateDeduction($subtotal) : 0) / 100;
        $this->subtotal = $subtotal - $this->discount;
        $this->total = $this->subtotal + $this->postage;

        $this->payer = (new Payer())->setPaymentMethod('paypal');

        $this->generateItemList();
        $this->generateDetails();
        $this->generateAmount();
        $this->generateTransaction();
        $this->generateRedirectUrls();
        $this->generatePayment();

        $this->payment->create($this->paypalContext);

        return $this->payment->toArray();
    }

    public function processPayment(mixed $params): PayPalModel|array
    {
        /** @var Request $params */
        $payment = Payment::get($params->input('payment.id'), $this->paypalContext);

        $paymentExecution = (new PaymentExecution())->setPayerId($params->input('payment.payer'));

        return $payment->execute($paymentExecution, $this->paypalContext)->toArray();
    }

    private function getItems(): Collection
    {
        $items = new Collection();

        $this->basket?->model()->items->each(function (ShopOrderItem $item) use (&$items) {
            $currentItem = new Item();
            $currentItem->setName($item->product->title)
                ->setCurrency('GBP')
                ->setQuantity((string) $item->quantity)
                ->setSku((string) $item->variant->id)
                ->setPrice($item->product_price / 100);

            $items->push($currentItem);
        });

        if ($this->discount > 0 && $this->basket?->discount()) {
            $thisItem = new Item();
            $thisItem->setName($this->basket->discount()->name)
                ->setCurrency('GBP')
                ->setQuantity((string) 1)
                ->setSku($this->basket->discount()->code)
                ->setPrice('-'.number_format($this->discount, 2));

            $items->push($thisItem);
        }

        return $items;
    }

    private function generateItemList(): void
    {
        $this->itemList = new ItemList();

        /** @var ShopOrderItem $shopOrder */
        $shopOrder = $this->basket?->model();

        $shipping_address = (new ShippingAddress())
            ->setRecipientName($shopOrder->address->name)
            ->setLine1($shopOrder->address->line_1)
            ->setLine2($shopOrder->address->line_2)
            ->setCity($shopOrder->address->town)
            ->setPostalCode($shopOrder->address->postcode)
            ->setCountryCode($shopOrder->postageCountry->iso_code);

        $this->itemList->setItems($this->getItems()->toArray())
            ->setShippingAddress($shipping_address);
    }

    private function generateDetails(): void
    {
        $this->details = (new Details())->setShipping($this->postage)
            ->setTax(0)
            ->setShippingDiscount(0)
            ->setSubtotal($this->subtotal);
    }

    private function generateAmount(): void
    {
        $this->amount = (new Amount())->setCurrency('GBP')
            ->setTotal($this->total)
            ->setDetails($this->details);
    }

    private function generateTransaction(): void
    {
        $this->transaction = (new Transaction())->setAmount($this->amount)
            ->setItemList($this->itemList)
            ->setDescription("Coeliac Sanctuary Order - {$this->basket?->model()->order_key}")
            ->setInvoiceNumber((string) $this->basket?->model()->order_key);
    }

    private function generateRedirectUrls(): void
    {
        $this->redirectUrls = (new RedirectUrls())
            ->setReturnUrl(Container::getInstance()->make(Repository::class)->get('app.url').'/shop/basket')
            ->setCancelUrl(Container::getInstance()->make(Repository::class)->get('app.url').'/shop/basket');
    }

    private function generatePayment(): void
    {
        $this->payment = (new Payment())->setIntent('sale')
            ->setPayer($this->payer)
            ->setRedirectUrls($this->redirectUrls)
            ->setTransactions([$this->transaction]);
    }
}
