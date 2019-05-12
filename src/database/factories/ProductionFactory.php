<?php

use App\Orm\Production;
use App\Orm\Tag;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Production::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(100),
        'excerpt' => $faker->sentence(10),
        'slug' => Str::slug(($faker->sentence(4))),
        'creator_id' => $user->id
    ];
})->afterCreating(Production::class, function (Production $production, Faker $faker) {
    $organization = factory(\App\Orm\Organization::class)->create();
    $production->organizations()->attach($organization);
    $production->addMediaFromBase64('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4wEbDCgCXDUMQAAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAAMSURBVAjXY/j//z8ABf4C/tzMWecAAAAASUVORK5CYII=')
        ->toMediaCollection('images');

    $production->attachTag(Tag::first());
});
