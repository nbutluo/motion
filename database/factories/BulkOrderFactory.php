<?php

use Faker\Generator as Faker;
use App\Model\Blog\Blog;
use App\Model\BulkOrder;

$factory->define(BulkOrder::class, function (Faker $faker) {
    $blog_ids = Blog::pluck('post_id')->toArray();
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'company' => $faker->company,
        'message' => $faker->sentence(),
        'blog_id' => $faker->randomElement($blog_ids)
    ];
});
