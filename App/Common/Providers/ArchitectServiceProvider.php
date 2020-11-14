<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Coeliac\Modules\Shop\Architect\OrderBlueprint;
use Coeliac\Modules\Shop\Architect\BasketBlueprint;
use Coeliac\Common\Users\Blueprint as UserBlueprint;
use Coeliac\Modules\Shop\Architect\ProductBlueprint;
use Coeliac\Modules\Shop\Architect\CategoryBlueprint;
use Coeliac\Modules\Shop\Architect\DiscountBlueprint;
use Coeliac\Common\Popups\Blueprint as PopupBlueprint;
use Coeliac\Modules\Shop\Architect\DailyStockBlueprint;
use Coeliac\Common\FeaturedImages\FeaturedImagesBlueprint;
use Coeliac\Modules\Shop\Architect\PostagePricesBlueprint;
use Coeliac\Common\Notifications\Blueprint as EmailBlueprint;
use Coeliac\Modules\Blog\Architect\Blueprint as BlogBlueprint;
use Coeliac\Modules\Recipe\Architect\Blueprint as RecipeBlueprint;
use Coeliac\Common\Announcements\Blueprint as AnnouncementBlueprint;
use JPeters\Architect\Providers\ArchitectApplicationServiceProvider;
use Coeliac\Common\Comments\Architect\Blueprint as CommentsBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\WhereToEatBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\PlaceRequestBlueprint;
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
//            FeaturedImagesBlueprint::class,
            CommentsBlueprint::class,
            WteRatingsBlueprint::class,
            AnnouncementBlueprint::class,
            PopupBlueprint::class,
            PlaceRequestBlueprint::class,
            UserBlueprint::class,
            EmailBlueprint::class,

            //
            BasketBlueprint::class,
            OrderBlueprint::class,
            DailyStockBlueprint::class,
            //Dispatch Slips
            CategoryBlueprint::class,
            ProductBlueprint::class,
            DiscountBlueprint::class,
            PostagePricesBlueprint::class,
        ];
    }

    public function dataSources(): array
    {
        return [];
    }

    public function register()
    {
        //
    }
}
