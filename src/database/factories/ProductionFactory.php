<?php

use App\Orm\Image;
use App\Orm\Production;
use App\User;
use Faker\Generator as Faker;

$factory->define(Production::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    return [
        'title' => $faker->sentence(3),
        'description' => $faker->sentence(100),
        'excerpt' => $faker->sentence(10),
        'slug' => str_slug($faker->sentence(4)),
        'header_img_id' => factory(Image::class)->create()->id,
        'creator_id' => $user->id
    ];
})->afterCreating(Production::class, function (Production $production, Faker $faker) {
    $organization = factory(\App\Orm\Organization::class)->create();
    $production->organizations()->attach($organization);
});
