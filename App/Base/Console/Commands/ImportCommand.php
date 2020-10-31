<?php

declare(strict_types=1);

namespace Coeliac\Base\Console\Commands;

use Imports\FaqImport;
use Imports\WteImport;
use Imports\BlogImport;
use Imports\PopupImport;
use Imports\RecipeImport;
use Imports\CommentImport;
use Imports\ReviewImporter;
use Imports\ShopOrderImport;
use Imports\ShopBasketImport;
use Imports\CoeliacInfoImport;
use Imports\ShopProductImport;
use Imports\ShopUsedDiscounts;
use Illuminate\Console\Command;
use Imports\PlaceRequestImport;
use Imports\ShopCategoryImport;
use Imports\AnnouncementsImport;
use Imports\ShopEtsyOrderImport;
use Imports\FeaturedImagesImport;
use Imports\ShopDiscountCodeImport;
use Imports\ShopPostagePriceImport;
use Imports\WhereToEatRatingImport;
use Imports\CommentRepliedEmailImport;
use Imports\ShopProductFeedbackImport;
use Imports\CommentApprovedEmailImport;
use Imports\ShopOrderShippedEmailImport;
use Imports\AttractionRestaurantImporter;
use Imports\ShopOrderCompleteEmailImport;
use Imports\WteRatingApprovedEmailImport;
use Imports\ShopOrderCancelledEmailImport;

class ImportCommand extends Command
{
    protected $signature = 'coeliac:import';

    public function handle()
    {
        $imports = [
            FeaturedImagesImport::class,
            BlogImport::class,
            RecipeImport::class,
            WteImport::class,
            ReviewImporter::class,
            CommentImport::class,
            AttractionRestaurantImporter::class,
            WhereToEatRatingImport::class,
            CoeliacInfoImport::class,
            FaqImport::class,
            ShopPostagePriceImport::class,
            ShopCategoryImport::class,
            ShopProductImport::class,
            ShopProductFeedbackImport::class,
            AnnouncementsImport::class,
            PopupImport::class,
            PlaceRequestImport::class,
            CommentApprovedEmailImport::class,
            CommentRepliedEmailImport::class,
            WteRatingApprovedEmailImport::class,
            ShopDiscountCodeImport::class,
            ShopBasketImport::class,
            ShopOrderImport::class,
            ShopUsedDiscounts::class,
            ShopEtsyOrderImport::class,
            ShopOrderCompleteEmailImport::class,
            ShopOrderShippedEmailImport::class,
             ShopOrderCancelledEmailImport::class,
        ];

        foreach ($imports as $import) {
            $import = new $import($this);

            $import->handle();
        }
    }

    public function makeProgressBar($length)
    {
        return $this->output->createProgressBar($length);
    }
}
