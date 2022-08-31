<?php

declare(strict_types=1);

namespace Coeliac\Common\Architect;

use Coeliac\Common\Models\Comment;
use Coeliac\Modules\EatingOut\WhereToEat\Models\PlaceRequest;
use Coeliac\Modules\EatingOut\WhereToEat\Models\WhereToEatReview;
use JPeters\Architect\Dashboards\AbstractDashboard;
use JPeters\Architect\Dashboards\Cards\Card;
use JPeters\Architect\Dashboards\Cards\Chart;

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
                    $count = WhereToEatReview::query()->where('approved', 0)->count();
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

            Chart::make('Emails', new EmailChart()),

            Chart::make('Submitted Ratings', new RatingsChart()),
        ];
    }
}
