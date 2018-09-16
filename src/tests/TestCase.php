<?php

namespace Tests;

use App\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Laravel\Passport\Passport;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function actingAsOrganizationMember(){
        return Passport::actingAs(
            factory(User::class)->create()
        );
    }
    protected function actingAsLoggedInUser(){
        return Passport::actingAs(
            factory(User::class)->create()
        );
    }
}
