<?php

declare(strict_types=1);

namespace Coeliac\Common;

use Carbon\Carbon;
use Coeliac\Common\Models\Comment;
use Illuminate\Support\Collection;
use Coeliac\Common\Models\NotificationEmail;
use JPeters\Architect\Dashboards\Cards\Card;
use JPeters\Architect\Dashboards\Cards\Chart;
use JPeters\Architect\Dashboards\AbstractDashboard;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatRating;

class ArchitectDashboard extends AbstractDashboard
{
    public function dashboardName(): string
    {
        return 'Coeliac Sanctuary';
    }

    public function dashboardRoute(): string
    {
        return 'dashboard';
    }

    public function cards(): array
    {
        return [
            Card::generate('New Comments')
                ->setWidth('third')
                ->setContent(static function () {
                    $count = Comment::query()->where('approved', 0)->count();
                    $class = $count > 0 ? 'text-red-500 font-semibold' : '';

                    return "<span class='text-lg {$class}'>{$count}</span>";
                }),

            Card::generate('New Ratings')
                ->setWidth('third')
                ->setContent(static function () {
                    $count = WhereToEatRating::query()->where('approved', 0)->count();
                    $class = $count > 0 ? 'text-red-500' : '';

                    return "<span class='text-lg {$class}'>{$count}</span>";
                }),

            Card::generate('Place Requests')
                ->setWidth('third')
                ->setContent(static function () {
                    $count = PlaceRequest::query()->where('completed', 0)->count();
                    $class = $count > 0 ? 'text-red-500 font-semibold' : '';

                    return "<span class='text-xl {$class}'>{$count}</span>";
                }),

            $this->generateEmailChart(),

            $this->generateRatingChart(),
        ];
    }

    protected function generateEmailChart(): Chart
    {
        $chart = Chart::generate('Emails');

        $days = new Collection();

        for ($x = 14; $x >= 0; --$x) {
            $days->push(Carbon::today()->subDays($x));
        }

        $chart->addLabels($days->map(fn ($day) => $day->format('Y/m/d'))->toArray());

        $counts = [];

        foreach ($days as $day) {
            $counts[] = NotificationEmail::query()
                ->whereDate('created_at', '>=', $day->startOfDay())
                ->whereDate('created_at', '<=', $day->endOfDay())
                ->count();
        }
        $chart->addDataSet('Sent Emails', $counts, 'line');

        return $chart;
    }

    protected function generateRatingChart(): Chart
    {
        $chart = Chart::generate('Submitted Ratings');

        $days = new Collection();

        for ($x = 14; $x >= 0; --$x) {
            $days->push(Carbon::today()->subDays($x));
        }

        $chart->addLabels($days->map(fn ($day) => $day->format('Y/m/d'))->toArray());

        $counts = [];

        foreach ($days as $day) {
            $counts[] = WhereToEatRating::query()
                ->whereDate('created_at', '>=', $day->startOfDay())
                ->whereDate('created_at', '<=', $day->endOfDay())
                ->count();
        }
        $chart->addDataSet('Submitted Ratings', $counts, 'line');

        return $chart;
    }
}
