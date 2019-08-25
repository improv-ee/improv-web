<?php

use App\Orm\Event;
use App\Orm\Organization;
use App\Orm\Production;
use App\Orm\Tag;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\App;

$factory->define(Event::class, function (Faker $faker) {
    $start = $faker->dateTimeBetween("-1 day", "+2 months");
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
        'creator_id' => $user->id,
        'place_id' => factory(\App\Orm\Place::class)->create()->id

    ];
})->afterCreating(Event::class, function (Event $event, Faker $faker) {

    // Use a dummy base64 picture for unit tests, but download a larger fancier picture for local dev env
    if (App::environment('testing')) {
        $media = $event->addMediaFromBase64('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4wEbDCgCXDUMQAAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAAMSURBVAjXY/j//z8ABf4C/tzMWecAAAAASUVORK5CYII=');
    } else {
        $media = $event->addMediaFromUrl('https://placekitten.com/600/400');
    }

    $media->toMediaCollection('images');
});
