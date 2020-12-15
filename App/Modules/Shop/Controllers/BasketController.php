<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Session\Store;
use Coeliac\Modules\Shop\Basket\Basket;
use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Coeliac\Modules\Shop\Response\ShopPage;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Exceptions\BasketException;
use Coeliac\Modules\Shop\Requests\AddToBasketRequest;
use Coeliac\Modules\Shop\Requests\BasketUpdateRequest;

class BasketController extends BaseController
{
    private Basket $basket;

    public function __construct(Basket $basket)
    {
        $this->basket = $basket;
    }

    public function index()
    {
        $items = 0;
        $quantity = 0;

        if ($this->basket->resolve()) {
            $items = $this->basket->model()->items()->count();
            $this->basket->model()->items->map(function ($item) use (&$quantity) {
                return $quantity += $item->quantity;
            });
        }

        return [
            'items' => $items,
            'quantity' => $quantity,
        ];
    }

    public function create(AddToBasketRequest $request)
    {
        try {
            $this->basket
                ->items()
                ->add($request->resolveProduct(), $request->resolveVariant(), $request->input('quantity'));

            return [
                'data' => 'ok',
            ];
        } catch (BasketException $exception) {
            return new Response([
                'error' => $exception->getMessage(),
            ], 422);
        }
    }

    public function get(Store $sessionStore)
    {
        $items = [];
        $subtotal = 0;
        $postage = 0;
        $delivery = '';
        $discount = [];
        $country = 1;

        if ($this->basket->resolve()) {
            $items = $this->basket
                ->model()
                ->items()
                ->with('product', 'variant', 'product.images', 'product.images.image', 'product.prices', 'product.shippingMethod')
                ->get()
                ->makeVisible(['product.first_image']);

            $subtotal = array_sum($items->pluck('subtotal')->toArray());
            $postage = $this->basket->postage()->calculate();
            $delivery = $this->basket->model()->postageCountry->area->delivery_timescale;
            $country = $this->basket->model()->postageCountry->id;
        }

        if ($sessionStore->has('basket_discount_code')) {
            /** @var ?ShopDiscountCode $discountCode */
            $discountCode = ShopDiscountCode::query()->firstWhere('code', $sessionStore->get('basket_discount_code'));

            if ($discountCode) {
                $discount = [
                    'code' => $discountCode->code,
                    'name' => $discountCode->name,
                    'deduction' => $discountCode->calculateDeduction($subtotal),
                ];
            }
        }

        return [
            'items' => $items,
            'subtotal' => $subtotal,
            'postage' => $postage,
            'country' => $country,
            'delivery' => $delivery,
            'discount' => $discount,
            'total' => $subtotal - ($discount['deduction'] ?? 0) + $postage,
        ];
    }

    public function update(BasketUpdateRequest $request)
    {
        try {
            $method = $request->input('action') . 'Quantity';

            $this->basket->items()->$method($request->resolveProduct(), $request->resolveVariant());

            return ['data' => 'ok'];
        } catch (BasketException $exception) {
            Bugsnag::notifyException($exception);

            return new Response(['error' => $exception->getMessage()], 400);
        } catch (Exception $exception) {
            Bugsnag::notifyException($exception);
            abort(500);
        }
    }

    public function show(ShopPage $page)
    {
        return $page
            ->breadcrumbs([
                [
                    'link' => '/shop',
                    'title' => 'Shop',
                ],
            ], 'Checkout')
            ->setPageTitle('Checkout | Coeliac Sanctuary')
            ->render('modules.shop.basket');
    }
}
