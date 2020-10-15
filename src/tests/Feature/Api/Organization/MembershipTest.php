<?php

namespace Tests\Feature\Api\Organization;

use App\Events\Organization\UserJoined;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Event;
use Tests\Feature\Api\ApiTestCase;

/**
 * @package Tests\Feature\Api\Organization
 * @covers \App\Http\Controllers\Api\V1\Organization\MembershipController
 */
class MembershipTest extends ApiTestCase
{
    use DatabaseMigrations;


    public function testOrganizationMemberCanBeAdded()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);
        $organization = $user->organizations()->first();
        $newMember = User::factory()->create();

        $response = $this->post(
            sprintf($this->getApiUrl() . '/organizations/%s/membership', $organization->uid),
            [
                'username' => $newMember->username,
            ]
        );

        $response->assertStatus(201);

        $this->assertDatabaseHas('organization_user', [
            'user_id' => $newMember->id,
            'organization_id' => $organization->id,
            'role' => OrganizationUser::ROLE_MEMBER]);
    }


    public function testShowReturnsMembershipInfo()
    {
        $user = $this->actingAsOrganizationMember();
        $org = $user->organizations()->first();
        $response = $this->get($this->getApiUrl() . '/organizations/' . $org->uid . '/membership/' . $user->username);


        $response->assertStatus(200)
            ->assertJson(['data' => [
                'organization' => [
                    'name' => $org->name
                ]
            ]]);

    }

    public function testCanNotJoinOrganizationTwice()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);
        $org = $user->organizations()->first();

        $this->assertDatabaseHas('organization_user', ['user_id' => $user->id, 'organization_id' => $org->id]);

        $response = $this->post(sprintf($this->getApiUrl() . '/organizations/%s/membership', $org->uid), ['username' => $user->username]);

        $response->assertStatus(400)
            ->assertJsonStructure(['errors' => []]);
    }


    public function testEventIsCreatedOnOrganizationJoin()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);
        $organization = $user->organizations()->first();
        $newMember = User::factory()->create();

        Event::fake();

        $this->post(sprintf($this->getApiUrl() . '/organizations/%s/membership', $organization->uid), ['username' => $newMember->username]);

        Event::assertDispatched(UserJoined::class, function ($e) use ($organization) {
            return $e->organizationUser->organization_id === $organization->id;
        });
    }

    public function testNonAdminCanNotAddMembers()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_MEMBER);
        $organization = $user->organizations()->first();
        $newMember = User::factory()->create();

        $response = $this->post(
            sprintf($this->getApiUrl() . '/organizations/%s/membership', $organization->uid),
            [
                'username' => $newMember->username,
            ]
        );

        $response->assertStatus(403);
    }

    public function testAdminCanDeleteMembership()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);
        $organization = $user->organizations()->first();

        $member = OrganizationUser::factory()
            ->create(['organization_id' => $organization->id]);

        $response = $this->delete(sprintf($this->getApiUrl() . '/organizations/%s/membership/%s', $organization->uid, $member->user->username));

        $response->assertStatus(200);
        $this->assertDatabaseMissing('organization_user', ['user_id' => $member->user->username]);
    }

    public function testNonAdminCanNotDeleteMembership()
    {
        $user = $this->actingAsOrganizationMember();
        $organization = $user->organizations()->first();

        $member = OrganizationUser::factory()
            ->create(['organization_id' => $organization->id]);

        $response = $this->delete(sprintf($this->getApiUrl() . '/organizations/%s/membership/%s', $organization->uid, $member->user->username));

        $response->assertStatus(403);
    }

    public function testDeletingNonExistingMembershipThrows()
    {
        $user = $this->actingAsOrganizationMember();
        $organization = $user->organizations()->first();

        $response = $this->delete(sprintf($this->getApiUrl() . '/organizations/%s/membership/%s', $organization->uid, 'batman'));

        $response->assertStatus(404);
    }

    public function testAdminCanChangeMembershipDetails()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);
        $organization = $user->organizations()->first();

        $member = OrganizationUser::factory()
            ->create(['organization_id' => $organization->id]);

        $response = $this->put(sprintf($this->getApiUrl() . '/organizations/%s/membership/%s', $organization->uid, $member->user->username), ['role' => OrganizationUser::ROLE_ADMIN]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('organization_user', [
            'user_id' => $member->user->id,
            'organization_id' => $member->organization->id,
            'role' => OrganizationUser::ROLE_ADMIN]);
    }
    public function testNonAdminCanNotChangeMembershipDetails()
    {
        $user = $this->actingAsOrganizationMember();
        $organization = $user->organizations()->first();

        $member = OrganizationUser::factory()
            ->create(['organization_id' => $organization->id]);

        $response = $this->put(sprintf($this->getApiUrl() . '/organizations/%s/membership/%s', $organization->uid, $member->user->username), ['role' => OrganizationUser::ROLE_ADMIN]);

        $response->assertStatus(403);

    }
}
