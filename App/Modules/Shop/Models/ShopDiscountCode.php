<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;

/**
 * @property mixed  $id
 * @property int    $max_claims
 * @property Carbon $start_at
 * @property Carbon $end_at
 */
class ShopDiscountCode extends BaseModel
{
    protected $casts = [
        'type_id' => 'int',
        'deduction' => 'int',
    ];

    protected $dates = [
        'start_at',
        'end_at',
    ];

    public function type()
    {
        return $this->belongsTo(ShopDiscountCodeType::class, 'type_id');
    }

    public function orders()
    {
        return $this->hasManyThrough(
            ShopOrder::class,
            ShopDiscountCodesUsed::class,
            'discount_id',
            'id',
            'id',
            'order_id'
        );
    }

    protected function used()
    {
        return $this->hasMany(ShopDiscountCodesUsed::class, 'discount_id');
    }

    public function associateOrder(ShopOrder $order, $amount)
    {
        $this->used()->create([
            'order_id' => $order->id,
            'discount_amount' => $amount,
        ]);
    }

    public function calculateDeduction($subtotal)
    {
        $deduction = $this->deduction;

        if ($this->type_id === ShopDiscountCodeType::PERCENTAGE) {
            $deduction = $subtotal / 100 * $deduction;
        }

        return $deduction;
    }
}
