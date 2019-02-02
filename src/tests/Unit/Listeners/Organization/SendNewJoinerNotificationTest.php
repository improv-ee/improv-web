<?php

namespace Tests\Unit\Listeners\Organization;

use App\Events\Organization\UserJoined;
use App\Notifications\Organization\YouWereAddedToOrganization;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class SendNewJoinerNotificationTest extends TestCase
{

    use DatabaseMigrations;

    public function testNotificationIsSentToJoiner()
    {
        $organization = factory(Organization::class)->create();

        $orgMemberJoiner = $this->actingAsLoggedInUser();
        $orgMemberAdmin1 = factory(User::class)->create();
        $orgMemberAdmin2 = factory(User::class)->create();
        $orgMember = factory(User::class)->create();

        $organization->users()->attach($orgMemberJoiner, ['role'=> OrganizationUser::ROLE_MEMBER, 'creator_id'=>$orgMemberJoiner->id]);
        $organization->users()->attach($orgMemberAdmin1, ['role' => OrganizationUser::ROLE_ADMIN,'creator_id'=>$orgMemberAdmin1->id]);
        $organization->users()->attach($orgMemberAdmin2, ['role' => OrganizationUser::ROLE_ADMIN,'creator_id'=>$orgMemberAdmin2->id]);
        $organization->users()->attach($orgMember, ['role' => OrganizationUser::ROLE_MEMBER, 'creator_id'=>$orgMember->id]);

        $member = OrganizationUser::getMembership($orgMemberJoiner->id, $organization->id);

        Notification::fake();

        event(new UserJoined($member));

        Notification::assertSentTo(
            [$orgMemberJoiner], YouWereAddedToOrganization::class
        );

        Notification::assertNotSentTo(
            [$orgMember,$orgMemberAdmin2,$orgMemberAdmin1], YouWereAddedToOrganization::class
        );

    }
}
