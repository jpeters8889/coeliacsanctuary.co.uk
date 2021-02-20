<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Basket;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Container\Container;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Session\Store as SessionStore;
use Illuminate\Contracts\Auth\Authenticatable;
use Coeliac\Modules\Shop\Models\ShopOrderState;
use Coeliac\Modules\Shop\Models\ShopDiscountCode;

class Basket
{
    protected Request $request;
    protected SessionStore $session;

    protected ShopOrder $basketModel;

    protected ?Items $items = null;

    protected ?Postage $postage = null;

    public function __construct(SessionStore $session)
    {
        $this->session = $session;
    }

    public function create()
    {
        $this->basketModel = ShopOrder::query()->create([
            'user_id' => resolve(Authenticatable::class)->id ?? null,
            'token' => $token = Str::random(8),
        ]);

        $this->session->put('basket_token', $token);
        $this->session->save();
    }

    public function items(): Items
    {
        if (!$this->items) {
            $this->items = new Items($this);
        }

        return $this->items;
    }

    public function postage(): Postage
    {
        if (!$this->postage) {
            $this->postage = new Postage($this);
        }

        return $this->postage;
    }

    public function subtotal()
    {
        return array_sum($this->model()->items->pluck('subtotal')->toArray());
    }

    public function discount(): ?ShopDiscountCode
    {
        $sessionStore = Container::getInstance()->make(SessionStore::class);

        if ($sessionStore->has('basket_discount_code')) {
            /** @var ?ShopDiscountCode $discountCode */
            $discountCode = ShopDiscountCode::query()->firstWhere('code', $sessionStore->get('basket_discount_code'));

            if ($discountCode) {
                return $discountCode;
            }
        }

        return null;
    }

    public function model(): ShopOrder
    {
        return $this->basketModel;
    }

    public function resolve()
    {
        if ($this->session->has('basket_token')) {
            $model = ShopOrder::query()
                ->where('token', $this->session->get('basket_token'))
                ->where('state_id', ShopOrderState::STATE_BASKET)
                ->first();

            if ($model) {
                $this->basketModel = $model;

                return true;
            }
        }

        return false;
    }
}
