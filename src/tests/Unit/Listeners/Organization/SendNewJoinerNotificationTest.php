<?php

namespace Tests\Unit\Listeners\Organization;

use App\Events\Organization\UserJoined;
use App\Notifications\Organization\NewMemberApplication;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNewJoinerNotificationTest extends TestCase
{

    use DatabaseMigrations;

    public function testNotificationIsSentToOrganizationAdmins()
    {
        $organization = factory(Organization::class)->create();

        $orgMemberJoiner = $this->actingAsLoggedInUser();
        $orgMemberAdmin1 = factory(User::class)->create();
        $orgMemberAdmin2 = factory(User::class)->create();
        $orgMember = factory(User::class)->create();

        $organization->users()->attach($orgMemberJoiner, ['role'=> OrganizationUser::ROLE_JOINER]);
        $organization->users()->attach($orgMemberAdmin1, ['role' => OrganizationUser::ROLE_ADMIN]);
        $organization->users()->attach($orgMemberAdmin2, ['role' => OrganizationUser::ROLE_ADMIN]);
        $organization->users()->attach($orgMember, ['role' => OrganizationUser::ROLE_MEMBER]);

        $member = OrganizationUser::getMembership($orgMemberJoiner->id, $organization->id);

        Notification::fake();

        event(new UserJoined($member));

        Notification::assertSentTo(
            [$orgMemberAdmin1,$orgMemberAdmin2], NewMemberApplication::class
        );

        Notification::assertNotSentTo(
            [$orgMember,$orgMemberJoiner], NewMemberApplication::class
        );

    }
}
