<?php

use App\User;
use Faker\Generator as Faker;

$factory->define(App\Orm\OrganizationUser::class, function (Faker $faker) {
    $user = factory(User::class)->create();
    $organization = factory(\App\Orm\Organization::class)->create();

    return [
        'organization_id' => $organization->id,
        'creator_id' => $user->id,
        'user_id' => $user->id,
        'role' => \App\Orm\OrganizationUser::ROLE_MEMBER

    ];
});
