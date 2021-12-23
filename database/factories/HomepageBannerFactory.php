<?php

use Faker\Generator as Faker;
use App\Model\HomepageBanner;

$factory->define(HomepageBanner::class, function (Faker $faker) {
    return [
        'description' => $faker->words(3, true),
        'media_url_pc' => $faker->imageUrl(1920, 520),
        'media_url_mobile' => $faker->imageUrl(375, 260),
        'banner_alt' => $faker->name,
        'order' => $faker->randomDigit,
        'link_url' => $faker->url,
        'is_active' => $faker->randomElement([0, 1]),
    ];
});
