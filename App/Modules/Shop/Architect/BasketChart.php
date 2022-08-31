<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopOrder;
use JPeters\Architect\Dashboards\Cards\Chartable;

class BasketChart extends Chartable
{
    protected function getData(Carbon $start, Carbon $end): int|float|array
    {
        $baskets = ShopOrder::query()
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->get();

        return [$baskets->count(), $baskets->whereNotNull('order_key')->count()];
    }

    protected function data(): array
    {
        $data = $this->calculateData();

        $baskets = array_map(fn (array $a) => $a[0], $data);
        $sales = array_map(fn (array $a) => $a[1], $data);

        return [
            [
                'label' => 'Baskets',
                'data' => $baskets,
                'borderColor' => 'blue',
                'backgroundColor' => 'blue',
            ],
            [
                'label' => 'Sales',
                'data' => $sales,
                'borderColor' => 'red',
                'backgroundColor' => 'red',
            ],
        ];
    }

    protected function dataLabel(): string
    {
        return 'Baskets / Orders';
    }

    protected function defaultRange(): string
    {
        return 'last14';
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
