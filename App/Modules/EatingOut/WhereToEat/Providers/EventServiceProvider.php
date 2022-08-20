<?php

declare(strict_types=1);

namespace Coeliac\Modules\EatingOut\WhereToEat\Providers;

use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRecommendationSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceReportSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PlaceRequestSubmitted;
use Coeliac\Modules\EatingOut\WhereToEat\Events\PrepareWhereToEatReviewImages;
use Coeliac\Modules\EatingOut\WhereToEat\Listeners\ProcessWhereToEatReviewImages;
use Coeliac\Modules\EatingOut\WhereToEat\Listeners\SendPlaceRecommendationEmail;
use Coeliac\Modules\EatingOut\WhereToEat\Listeners\SendPlaceReportEmail;
use Coeliac\Modules\EatingOut\WhereToEat\Listeners\SendPlaceRequestEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        PlaceRequestSubmitted::class => [
            SendPlaceRequestEmail::class,
        ],

        PlaceRecommendationSubmitted::class => [
            SendPlaceRecommendationEmail::class,
        ],

        PlaceReportSubmitted::class => [
            SendPlaceReportEmail::class,
        ],

        PrepareWhereToEatReviewImages::class => [
            ProcessWhereToEatReviewImages::class,
        ],
    ];
}
