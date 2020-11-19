<?php

namespace Coeliac\Modules\Shop\Architect;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Coeliac\Modules\Shop\Models\ShopOrder;
use JPeters\Architect\Dashboards\Cards\Chart;
use JPeters\Architect\Dashboards\AbstractDashboard;

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
            $this->basketChart(),
            $this->income(),
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

    protected function income(): Chart
    {
        $chart = Chart::generate('Income');

        $months = new Collection();

        for ($x = 12; $x >= 0; --$x) {
            $months->push(Carbon::today()->subMonth($x));
        }

        $chart->addLabels($months->map(fn ($day) => $day->format('M Y'))->toArray());

        $income = [];

        foreach ($months as $month) {
            /** @var ShopOrder $total */
            $total = 0;

            ShopOrder::query()
                ->whereDate('created_at', '>=', $month->startOfMonth())
                ->whereDate('created_at', '<=', $month->endOfMonth())
                ->whereNotNull('order_key')
                ->with('payment')
                ->get()
                ->map(function (ShopOrder $order) use (&$total) {
                    $total += $order->payment->total;
                });

            $income[] = $total / 100;
        }
        $chart->addDataSet('Income', $income, 'line');

        return $chart;
    }
}
