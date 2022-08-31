<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopOrder;
use JPeters\Architect\Dashboards\Cards\Chartable;

class IncomeChart extends Chartable
{
    protected function getData(Carbon $start, Carbon $end): int|float
    {
        $total = 0;

        ShopOrder::query()
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->whereNotNull('order_key')
            ->with('payment')
            ->get()
            ->map(function (ShopOrder $order) use (&$total) {
                $total += $order->payment?->total;
            });

        return $total / 100;
    }

    protected function dataLabel(): string
    {
        return 'Income';
    }

    protected function defaultRange(): string
    {
        return 'lastYear';
    }

    protected function options(): array
    {
        return [
            'scales' => [
                'y' => [
                    'min' => 0,
                ],
            ],
        ];
    }
}
