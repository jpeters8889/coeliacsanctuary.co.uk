<?php

use Coeliac\Modules\Shop\Models\ShopOrderReview;
use Coeliac\Modules\Shop\Models\ShopFeedback;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        ShopFeedback::query()->get()->each(function (ShopFeedback $feedback) {
           /** @var ShopOrderReview $review */
           $review = ShopOrderReview::query()->create([
               'name' => $feedback->name,
               'created_at' => $feedback->created_at,
               'updated_at' => $feedback->updated_at,
               ]);

           $review->products()->create([
               'product_id' => $feedback->product_id,
               'rating' => 5,
               'review' => $feedback->feedback,
               'created_at' => $feedback->created_at,
               'updated_at' => $feedback->updated_at,
           ]);
        });
    }
};
