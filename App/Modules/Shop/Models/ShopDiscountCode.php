<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Models;

use Carbon\Carbon;
use Coeliac\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * @property mixed $id
 * @property int $max_claims
 * @property Carbon $start_at
 * @property Carbon $end_at
 * @property int $deduction
 * @property int $type_id
 * @property string $code
 * @property string $name
 * @property int $min_spend
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

    public function type(): BelongsTo
    {
        return $this->belongsTo(ShopDiscountCodeType::class, 'type_id');
    }

    public function orders(): HasManyThrough
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

    protected function used(): HasMany
    {
        return $this->hasMany(ShopDiscountCodesUsed::class, 'discount_id');
    }

    public function associateOrder(ShopOrder $order, int|float $amount): void
    {
        $this->used()->create([
            'order_id' => $order->id,
            'discount_amount' => $amount,
        ]);
    }

    public function calculateDeduction(int|float $subtotal): int|float
    {
        $deduction = $this->deduction;

        if ($this->type_id === ShopDiscountCodeType::PERCENTAGE) {
            if (!is_int($subtotal)) {
                $subtotal *= 100;
            }

            $deduction = $subtotal / 100 * $deduction;
        }

        return (int) $deduction;
    }
}
