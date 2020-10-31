<?php

declare(strict_types=1);

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use Faker\Generator as Faker;
use Coeliac\Modules\Shop\Models\ShopProduct;
use Coeliac\Modules\Shop\Models\ShopShippingMethod;

$factory->define(ShopProduct::class, function (Faker $faker) {
    return [
        'title' => $faker->words(3, true),
        'meta_description' => $faker->sentence,
        'meta_keywords' => $faker->sentence,
        'slug' => $faker->slug,
        'description' => $faker->sentence,
        'long_description' => $faker->paragraphs(2, true),
        'shipping_method_id' => factory(ShopShippingMethod::class)->create()->id,
        'pinned' => false,
    ];
});
