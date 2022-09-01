<?php

declare(strict_types=1);

namespace Coeliac\Modules\Shop\Architect;

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
            Chart::make('products', new ProductSalesChart()),
        ];
    }
}
