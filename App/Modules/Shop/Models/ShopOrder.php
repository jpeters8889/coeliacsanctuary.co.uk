<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Coeliac\Modules\Member\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Coeliac\Modules\Member\Models\UserAddress;

/**
 * @property ShopOrderState            $state
 * @property User                      $user
 * @property UserAddress               $address
 * @property mixed|string              $id
 * @property mixed|string              $token
 * @property ShopPostageCountry        $postageCountry
 * @property mixed|string              $customer_id
 * @property mixed|string              $customer_address_id
 * @property ShopPayment               $payment
 * @property string                    $order_key
 * @property bool                      $newsletter_signup
 * @property ShopDiscountCode          $discountCode
 * @property Carbon                    $created_at
 * @property int                       $items_count
 * @property Carbon|null               $shipped_at
 * @property Collection<ShopOrderItem> $items
 */
class ShopOrder extends BaseModel
{
    protected $casts = [
        'user_id' => 'int',
        'postage_country_id' => 'int',
        'state_id' => 'int',
        'newsletter_signup' => 'bool',
        'order_key' => 'int',
    ];

    protected $dates = ['shipped_at'];

    public function state()
    {
        return $this->belongsTo(ShopOrderState::class, 'state_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function address()
    {
        return $this->belongsTo(UserAddress::class, 'user_address_id')->withTrashed();
    }

    public function addProduct(ShopProductVariant $variant, $quantity = 1)
    {
        $title = $variant->product->title;

        if ($variant->title) {
            $title .= " ({$variant->title})";
        }

        $this->items()->create([
            'product_id' => $variant->product->id,
            'product_variant_id' => $variant->id,
            'quantity' => $quantity,
            'product_title' => $title,
            'product_price' => $variant->product->currentPrice,
        ]);

        $variant->decrement('quantity', $quantity);

        $this->touch();
    }

    public function payment()
    {
        return $this->hasOne(ShopPayment::class, 'order_id');
    }

    public function items()
    {
        return $this->hasMany(ShopOrderItem::class, 'order_id');
    }

    public function postageCountry()
    {
        return $this->belongsTo(ShopPostageCountry::class, 'postage_country_id');
    }

    public function markAs($what)
    {
        $this->update([
            'state_id' => $what,
        ]);
    }

    public function markAsPaid()
    {
        $this->markAs(ShopOrderState::STATE_PAID);
    }

    public function setPubllicKey()
    {
        $this->order_key = $this->generateKey();
        $this->save();
    }

    private function generateKey()
    {
        $key = randomNumber();

        if (self::query()->where('order_key', $key)->where('state_id', '!=', '1')->count() === 0) {
            return $key;
        }

        return $this->generateKey();
    }

    public function discountCode()
    {
        return $this->hasOneThrough(ShopDiscountCode::class, ShopDiscountCodesUsed::class, 'order_id', 'id', 'id', 'discount_id');
    }
}
