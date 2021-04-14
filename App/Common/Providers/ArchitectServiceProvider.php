<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Coeliac\Common\ArchitectDashboard;
use Coeliac\Common\Architect\HorizonDashboard;
use Coeliac\Common\Architect\MailcoachDashboard;
use Coeliac\Modules\Shop\Architect\ShopDashboard;
use Coeliac\Modules\Shop\Architect\OrderBlueprint;
use Coeliac\Modules\Member\Architect\UserBlueprint;
use Coeliac\Modules\Shop\Architect\BasketBlueprint;
use Coeliac\Modules\Shop\Architect\ProductBlueprint;
use Coeliac\Modules\Shop\Architect\CategoryBlueprint;
use Coeliac\Modules\Shop\Architect\DiscountBlueprint;
use Coeliac\Common\Popups\Blueprint as PopupBlueprint;
use Coeliac\Modules\Shop\Architect\DailyStockBlueprint;
use Coeliac\Modules\Shop\Architect\MassDiscountsBlueprint;
use Coeliac\Modules\Shop\Architect\PostagePricesBlueprint;
use Coeliac\Common\Notifications\Blueprint as EmailBlueprint;
use Coeliac\Modules\Blog\Architect\Blueprint as BlogBlueprint;
use Coeliac\Modules\Recipe\Architect\Blueprint as RecipeBlueprint;
use Coeliac\Common\Announcements\Blueprint as AnnouncementBlueprint;
use JPeters\Architect\Providers\ArchitectApplicationServiceProvider;
use Coeliac\Common\Comments\Architect\Blueprint as CommentsBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\WhereToEatBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\PlaceRequestBlueprint;
use Coeliac\Modules\Search\Architect\Blueprint as SearchHistoryBlueprint;
use Coeliac\Modules\Collection\Architect\Blueprint as CollectionsBlueprint;
use Coeliac\Modules\Competition\Architect\Blueprint as CompetitionsBlueprint;
use Coeliac\Modules\EatingOut\Reviews\Architect\Blueprint as ReviewBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\RatingsBlueprint as WteRatingsBlueprint;

class ArchitectServiceProvider extends ArchitectApplicationServiceProvider
{
    protected function blueprints(): array
    {
        return [
            BlogBlueprint::class,
            ReviewBlueprint::class,
            RecipeBlueprint::class,
            WhereToEatBlueprint::class,
            CollectionsBlueprint::class,
            CommentsBlueprint::class,
            WteRatingsBlueprint::class,
            CompetitionsBlueprint::class,
            AnnouncementBlueprint::class,
            PopupBlueprint::class,
            PlaceRequestBlueprint::class,
            UserBlueprint::class,

            EmailBlueprint::class,
            SearchHistoryBlueprint::class,

            BasketBlueprint::class,
            OrderBlueprint::class,
            DailyStockBlueprint::class,
            //Dispatch Slips
            CategoryBlueprint::class,
            ProductBlueprint::class,
            MassDiscountsBlueprint::class,
            DiscountBlueprint::class,
            PostagePricesBlueprint::class,
        ];
    }

    public function dashboards(): array
    {
        return [
            ArchitectDashboard::class,
            ShopDashboard::class,
            HorizonDashboard::class,
            MailcoachDashboard::class,
        ];
    }
}
