<?php

namespace Tests\Feature;

use Tests\Abstracts\DashboardTest;

class OrderDashboardTest extends DashboardTest
{
    protected function page(): string
    {
        return 'orders';
    }

    protected function mustBeVerified(): bool
    {
        return true;
    }
}
