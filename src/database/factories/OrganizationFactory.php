<?php

use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Orm\Organization::class, function (Faker $faker) {
    $user = factory(User::class)->create();

    return [
        'name' => $faker->sentence(3),
        'creator_id' => $user->id,
        'is_public' => true

    ];
});
