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
            ->where('created_at', '>=', $start)
            ->where('created_at', '<=', $end)
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
