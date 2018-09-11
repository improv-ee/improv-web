<?php

use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(App\Orm\Event::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween("+1 month", "+2 months");
    $production = factory(Production::class)->create();
    $user = factory(User::class)->create();

    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(100),
        'start_time' => $start,
        'production_id' =>$production->id,
        'end_time' => Carbon::instance($start)->addHour(),
        'creator_id' => $user->id

    ];
});
