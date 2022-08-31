<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

use Carbon\Carbon;
use Coeliac\Modules\Shop\Models\ShopOrder;
use Illuminate\Support\Collection;
use JPeters\Architect\Dashboards\AbstractDashboard;
use JPeters\Architect\Dashboards\Cards\Chart;

class ShopDashboard extends AbstractDashboard
{
    public function dashboardName(): string
    {
        return 'Shop Dashboard';
    }

    public function dashboardRoute(): string
    {
        return 'shop';
    }

    public function cards(): array
    {
        return [
            Chart::make('Baskets', new BasketChart()),
            Chart::make('Income', new IncomeChart()),
        ];
    }

    protected function basketChart(): Chart
    {
        $chart = Chart::generate('Baskets');

        $days = new Collection();

        for ($x = 14; $x >= 0; --$x) {
            $days->push(Carbon::today()->subDays($x));
        }

        $chart->addLabels($days->map(fn ($day) => $day->format('Y/m/d'))->toArray());

        $baskets = [];
        $converted = [];

        foreach ($days as $day) {
            $total = ShopOrder::query()
                ->whereDate('created_at', '>=', $day->startOfDay())
                ->whereDate('created_at', '<=', $day->endOfDay())
                ->get();

            $baskets[] = $total->count();
            $converted[] = $total->whereNotNull('order_key')->count();
        }
        $chart->addDataSet('Total Baskets', $baskets, 'line');
        $chart->addDataSet('Orders', $converted, 'line');

        return $chart;
    }
}
