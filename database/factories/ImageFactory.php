<?php

use App\Post;
use App\User;
use App\Image;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'post_id' => function () {
            return factory(Post::class)->create()->id;
        },
        'actual' => $faker->imageUrl(),
        'large' => $faker->imageUrl(),
        'medium' => $faker->imageUrl(),
        'tiny' => $faker->imageUrl(),
        'small' => $faker->imageUrl(),

    ];
});
