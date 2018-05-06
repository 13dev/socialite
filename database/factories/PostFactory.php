<?php

use Faker\Generator as Faker;
use App\User;
use App\Post;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'post' => substr($faker->paragraph, 0, 139),
    ];
});
