<?php

declare(strict_types=1);

namespace Coeliac\Common\Architect;

use Carbon\Carbon;
use Coeliac\Common\Models\NotificationEmail;
use JPeters\Architect\Dashboards\Cards\Chartable;

class EmailChart extends Chartable
{
    protected function getData(Carbon $start, Carbon $end): int|float
    {
        return NotificationEmail::query()
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->count();
    }

    protected function dataLabel(): string
    {
        return 'Sent Emails';
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
