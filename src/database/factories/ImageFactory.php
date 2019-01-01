<?php

use App\Orm\Image;
use App\User;
use Faker\Generator as Faker;

$factory->define(Image::class, function (Faker $faker) {
    $user = factory(User::class)->create();

    return [
        'uid' => $faker->uuid(),
        'filename' => 'image.png',
        'creator_id' => $user->id
    ];
});
