<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Controllers;

use Bugsnag\BugsnagLaravel\Facades\Bugsnag;
use Coeliac\Base\Controllers\BaseController;
use Coeliac\Modules\Shop\Basket\Basket;
use Coeliac\Modules\Shop\Exceptions\BasketException;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;
use Coeliac\Modules\Shop\Models\ShopOrderItem;
use Coeliac\Modules\Shop\Requests\AddToBasketRequest;
use Coeliac\Modules\Shop\Requests\BasketUpdateRequest;
use Coeliac\Modules\Shop\Response\ShopPage;
use Exception;
use Illuminate\Http\Response;
use Illuminate\Session\Store;

class BasketController extends BaseController
{
    public function __construct(private Basket $basket)
    {
    }

    public function index(): array
    {
        $items = 0;
        $quantity = 0;

        if ($this->basket->resolve()) {
            $items = $this->basket->model()->items()->count();
            $this->basket->model()->items->each(function (ShopOrderItem $item) use (&$quantity) {
                return $quantity += $item->quantity;
            });
        }

        return [
            'items' => $items,
            'quantity' => $quantity,
        ];
    }

    public function create(AddToBasketRequest $request): array|Response
    {
        try {
            $this->basket
                ->items()
                ->add($request->resolveProduct(), $request->resolveVariant(), $request->input('quantity'));

            return [
                'data' => $this->basket->model()->items()->latest()->first(),
            ];
        } catch (BasketException $exception) {
            return new Response([
                'error' => $exception->getMessage(),
            ], 422);
        }
    }

    public function get(Store $sessionStore): array
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
                ->makeVisible(['product.first_image'])
                ->map(fn ($item) => array_merge($item->toArray(), ['id' => sha1((string) $item['id'])]));

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

    public function update(BasketUpdateRequest $request): array|Response
    {
        try {
            $method = $request->input('action').'Quantity';

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

    public function show(ShopPage $page): Response
    {
        return $page
            ->breadcrumbs([
                [
                    'link' => '/shop',
                    'title' => 'Shop',
                ],
            ], 'Checkout')
            ->setPageTitle('Checkout | Coeliac Sanctuary')
            ->doNotIndex()
            ->render('modules.shop.basket');
    }
}
