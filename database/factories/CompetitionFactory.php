<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Modules\Competition\Models\Competition::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'description' => $faker->paragraphs(3, true),
        'meta_keywords' => implode(',', $faker->words(10)),
        'meta_description' => $faker->paragraph,
        'start_at' => \Carbon\Carbon::tomorrow()->startOfDay(),
        'end_at' => \Carbon\Carbon::tomorrow()->addWeek()->endOfDay(),
        'promote_on_banner' => true,
        'enable_facebook_like' => true,
        'enable_facebook_share' => true,
        'enable_twitter_follow' => true,
        'enable_twitter_tweet' => true,
        'enable_shop_purchase' => true,
        'terms' => $faker->paragraphs(10, true),
    ];
});
