<?php

use App\Orm\Production;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;

$factory->define(App\Orm\Event::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween("+1 month", "+2 months");
    $production = factory(Production::class)->create();
    $production->addMediaFromBase64(base64_encode(UploadedFile::fake()->image('header.jpg', 900, 506)->get()))
        ->toMediaCollection('images');

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
