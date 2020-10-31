<?php

declare(strict_types=1);

use Faker\Generator as Faker;

$factory->define(\Coeliac\Common\Models\CommentReply::class, function (Faker $faker) {
    return [
        'comment_reply' => $faker->paragraph,
    ];
});
