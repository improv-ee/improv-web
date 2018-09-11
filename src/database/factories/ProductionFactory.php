<?php

use Faker\Generator as Faker;

$factory->define(App\Orm\Production::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(100),
        'excerpt' => $faker->sentence(10),
        'slug' => str_slug($faker->sentence(4))

    ];
});
