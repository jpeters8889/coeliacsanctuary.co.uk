<?php

declare(strict_types=1);

namespace Coeliac\Common\Providers;

use Coeliac\Common\Announcements\Blueprint as AnnouncementBlueprint;
use Coeliac\Common\Architect\HorizonDashboard;
use Coeliac\Common\Architect\MailcoachDashboard;
use Coeliac\Common\ArchitectDashboard;
use Coeliac\Common\Comments\Architect\Blueprint as CommentsBlueprint;
use Coeliac\Common\Notifications\Blueprint as EmailBlueprint;
use Coeliac\Common\Popups\Blueprint as PopupBlueprint;
use Coeliac\Modules\Blog\Architect\Blueprint as BlogBlueprint;
use Coeliac\Modules\Collection\Architect\Blueprint as CollectionsBlueprint;
use Coeliac\Modules\Competition\Architect\Blueprint as CompetitionsBlueprint;
use Coeliac\Modules\EatingOut\Reviews\Architect\Blueprint as ReviewBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\MyPlacesBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\PlaceRecommendationsBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\PlaceReportsBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\SuggestedEditBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\WhereToEatBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\WhereToEatCuisinesBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\WhereToEatReviews as WteRatingsBlueprint;
use Coeliac\Modules\EatingOut\WhereToEat\Architect\WhereToEatVenueTypesBlueprint;
use Coeliac\Modules\Member\Architect\LoginAttemptsBlueprint;
use Coeliac\Modules\Member\Architect\PasswordChangesBlueprint;
use Coeliac\Modules\Member\Architect\UserBlueprint;
use Coeliac\Modules\Recipe\Architect\Blueprint as RecipeBlueprint;
use Coeliac\Modules\Search\Architect\Blueprint as SearchHistoryBlueprint;
use Coeliac\Modules\Shop\Architect\BasketBlueprint;
use Coeliac\Modules\Shop\Architect\CategoryBlueprint;
use Coeliac\Modules\Shop\Architect\DailyStockBlueprint;
use Coeliac\Modules\Shop\Architect\DiscountBlueprint;
use Coeliac\Modules\Shop\Architect\MassDiscountsBlueprint;
use Coeliac\Modules\Shop\Architect\OrderBlueprint;
use Coeliac\Modules\Shop\Architect\PostagePricesBlueprint;
use Coeliac\Modules\Shop\Architect\ProductBlueprint;
use Coeliac\Modules\Shop\Architect\ShopDashboard;
use Coeliac\Modules\Shop\Architect\ShopReviewsBlueprint;
use Coeliac\Modules\Shop\Architect\TravelCardSearchHistoryBlueprint;
use Coeliac\Modules\Shop\Architect\TravelCardSearchTermsBlueprint;
use JPeters\Architect\Providers\ArchitectApplicationServiceProvider;

class ArchitectServiceProvider extends ArchitectApplicationServiceProvider
{
    protected function blueprints(): array
    {
        return [
            BlogBlueprint::class,
            ReviewBlueprint::class,
            RecipeBlueprint::class,
            CollectionsBlueprint::class,
            UserBlueprint::class,

            WhereToEatBlueprint::class,
            WteRatingsBlueprint::class,
            PlaceRecommendationsBlueprint::class,
            MyPlacesBlueprint::class,
            PlaceReportsBlueprint::class,
            WhereToEatVenueTypesBlueprint::class,
            WhereToEatCuisinesBlueprint::class,
            SuggestedEditBlueprint::class,

            CommentsBlueprint::class,

            AnnouncementBlueprint::class,
            CompetitionsBlueprint::class,
            PopupBlueprint::class,

            EmailBlueprint::class,
            LoginAttemptsBlueprint::class,
            PasswordChangesBlueprint::class,

            SearchHistoryBlueprint::class,
            TravelCardSearchTermsBlueprint::class,
            TravelCardSearchHistoryBlueprint::class,

            BasketBlueprint::class,
            OrderBlueprint::class,
            DailyStockBlueprint::class,
            //Dispatch Slips
            CategoryBlueprint::class,
            ProductBlueprint::class,
            ShopReviewsBlueprint::class,
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
