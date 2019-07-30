<?php

use App\Orm\Organization;
use App\Orm\Production;
use App\Orm\Tag;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\App;

$factory->define(Production::class, function (Faker $faker) {
    $user = User::inRandomOrder()->first();
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(100),
        'excerpt' => $faker->sentence(10),
        'creator_id' => $user->id
    ];
})->afterCreating(Production::class, function (Production $production, Faker $faker) {
    $organization = Organization::inRandomOrder()->first();
    $production->organizations()->attach($organization);

    // Use a dummy base64 picture for unit tests, but download a larger fancier picture for local dev env
    if (App::environment('testing')) {
        $media = $production->addMediaFromBase64('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4wEbDCgCXDUMQAAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAAMSURBVAjXY/j//z8ABf4C/tzMWecAAAAASUVORK5CYII=');
    } else {
        $media = $production->addMediaFromUrl('https://placekitten.com/600/400');
    }

    $media->toMediaCollection('images');

    $production->attachTag(Tag::first());
});
