<?php

use Faker\Generator as Faker;

$factory->define(App\Orm\Place::class, function (Faker $faker) {
    return [
        'uid' => $faker->uuid
    ];
});
