<?php

namespace Tests\Unit;

use App\Orm\Organization;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OrganizationTest extends TestCase
{

    use DatabaseMigrations;
    public function testAmMemberReturnsTrueIfUserIsMember()
    {

        $user = $this->actingAsLoggedInUser();
        $organization = factory(Organization::class)->create();
        $organization->users()->attach($user,['creator_id'=>$user->id]);

        $this->assertTrue($organization->isMember($user));
    }

    public function testAmMemberReturnsFalseIfUserIsNotMember()
    {

        $user = $this->actingAsLoggedInUser();
        $organization = factory(Organization::class)->create();

        $this->assertFalse($organization->isMember($user));
    }
}
