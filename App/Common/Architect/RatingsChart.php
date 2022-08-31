<?php

declare(strict_types=1);

namespace Coeliac\Common\Architect;

use Carbon\Carbon;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use JPeters\Architect\Dashboards\Cards\Chartable;

class RatingsChart extends Chartable
{
    protected function getData(Carbon $start, Carbon $end): int|float
    {
        return WhereToEatReview::query()
            ->whereDate('created_at', '>=', $start)
            ->whereDate('created_at', '<=', $end)
            ->count();
    }

    protected function defaultRange(): string
    {
        return 'last14';
    }

    protected function dataLabel(): string
    {
        return 'Submitted Ratings';
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
