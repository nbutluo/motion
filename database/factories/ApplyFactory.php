<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;
use App\Models\Apply;

$factory->define(Apply::class, function (Faker $faker) {

    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();

    // 为创建时间传参，意为最大不超过 $updated_at，因为创建时间需永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'user_id' => $faker->numberBetween(1, 10),
        'apply_reason' => $faker->text(),
        // 'is_audit' => $faker->randomElement([0, 1]),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
