<?php

namespace Tests;

use App\Orm\Organization;
use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @return \Illuminate\Contracts\Auth\Authenticatable|User
     */
    protected function actingAsOrganizationMember(){
        $user = factory(User::class)->create();
        $organization = factory(Organization::class)->create();
        $organization->users()->attach($user);
        return Passport::actingAs($user);
    }

    protected function actingAsLoggedInUser(){
        return Passport::actingAs(
            factory(User::class)->create()
        );
    }
}
