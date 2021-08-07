<?php

declare(strict_types=1);

namespace Coeliac\Common\Architect;

use JPeters\Architect\Dashboards\Cards\Card;
use JPeters\Architect\Dashboards\AbstractDashboard;

class HorizonDashboard extends AbstractDashboard
{
    public function dashboardName(): string
    {
        return 'Horizon';
    }

    public function dashboardRoute(): string
    {
        return 'horizon';
    }

    public function cards(): array
    {
        return [
            Card::generate('')
                ->setContent(
                    <<<STR
                    <p class="mb-2">Horizon is the Queue management and viewing application.</p>
                    <p><a href="/horizon" target="_blank">Go To Horizon</a></p>
                    STR
                ),
        ];
    }
}
