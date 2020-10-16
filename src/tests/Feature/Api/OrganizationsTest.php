<?php

namespace Tests\Feature\Api;

use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

/**
 * @covers \App\Http\Controllers\Api\V1\OrganizationController
 * @package Tests\Feature\Api
 */
class OrganizationsTest extends ApiTestCase
{
    use DatabaseMigrations;


    public function testOrganizationsListCanBeFilteredByName()
    {
        Organization::factory()->create(['name' => 'Ruutu10 team nr 1' ]);
        Organization::factory()->create(['name' => 'Ruutu10 team nr 2']);
        Organization::factory()->create(['name' => 'Ruutu10 majatiim']);
        Organization::factory()->count( 10)->create();

        $response = $this->get($this->getApiUrl() . '/organizations?filter[name]=Ruutu10');
        $response->assertStatus(200)
            ->assertJsonCount(3, 'data');
    }

    public function testOrganizationCanBeCreated()
    {
        $user = $this->actingAsLoggedInUser();


        $name = 'Justice League';
        $response = $this->post($this->getApiUrl() . '/organizations', [
            'name' => $name
        ]);

        $response->assertStatus(201)
            ->assertJson(['data' => ['name' => $name, 'is_public' => false]]);

        $this->assertDatabaseHas('organization_translations', [
            'name' => $name
        ]);
        $this->assertDataBaseHas('organizations', ['creator_id' => $user->id, 'is_public' => 0]);
    }

    public function testOrganizationCanBeDeleted()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);
        $organization = $user->organizations()->first();
        $this->assertNull($organization->deleted_at);

        $response = $this->delete($this->getApiUrl() . '/organizations/' . $organization->uid);
        $response->assertStatus(200);

        $organization->refresh();
        $this->assertNotNull($organization->deleted_at);
    }

    public function testOrganizationCanNotBeDeletedByNonMember()
    {
        $this->actingAsLoggedInUser();
        $organization = Organization::factory()->create();

        $response = $this->delete($this->getApiUrl() . '/organizations/' . $organization->uid);
        $response->assertStatus(403);

    }

    public function testOrganizationCanNotBeDeletedByNonAdmin()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_MEMBER);
        $organization = $user->organizations()->first();

        $response = $this->delete($this->getApiUrl() . '/organizations/' . $organization->uid);
        $response->assertStatus(403);

        $organization->refresh();
        $this->assertNull($organization->deleted_at);
    }

    public function testOrganizationCreatorGetsAdmin()
    {
        $user = $this->actingAsLoggedInUser();

        $organizationName = 'The Evil League of Evil';
        $response = $this->post($this->getApiUrl() . '/organizations', [
            'name' => $organizationName
        ]);

        $response->assertStatus(201);

        $org = $user->organizations()->first();

        $this->assertEquals($organizationName, $org->name);
        $this->assertEquals(OrganizationUser::ROLE_ADMIN, $org->pivot->role);

    }

    public function testOrganizationWithExistingNameCanNotBeCreated()
    {

        $user = $this->actingAsOrganizationMember();

        $response = $this->post($this->getApiUrl() . '/organizations', [
            'name' => $user->organizations()->first()->name
        ]);

        $response->assertStatus(422);
    }

    public function testOrganizationCanBeEdited()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);

        $organization = $user->organizations()->first();

        $newInput = ['name' => $organization->name, 'is_public' => true, 'description' => 'new description'];

        $response = $this->put($this->getApiUrl() . '/organizations/' . $organization->uid, $newInput);

        $response->assertStatus(200)
            ->assertJson(['data' => ['name' => $newInput['name']]]);

        $this->assertDatabaseHas('organization_translations', ['name' => $organization->name, 'description' => $newInput['description']]);
        $this->assertDatabaseHas('organizations', ['is_public' => 1, 'id' => $organization->id]);
    }

    public function testHeaderImageCanBeAdded()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);

        $organization = $user->organizations()->first();

        $newInput = [
            'name' => $organization->name,
            'is_public' => true,
            'description' => 'new description',
            'images' => ['header' => ['content' =>
                base64_encode(UploadedFile::fake()->image('header.png', 900, 506)->get())
            ]]
        ];

        $response = $this->put($this->getApiUrl() . '/organizations/' . $organization->uid, $newInput);

        $response->assertStatus(200);
        $this->assertCount(1, $organization->getMedia('images'));
        $this->assertEquals('image/png', $organization->getFirstMedia('images')->mime_type);
    }

    public function testUserCanNotEditOrganizationIfNotAdmin()
    {
        $user = $this->actingAsOrganizationMember();
        $organization = $user->organizations()->first();

        $newInput = ['name' => 'X-Force'];

        $response = $this->put($this->getApiUrl() . '/organizations/' . $organization->uid, $newInput);
        $response->assertStatus(403);
    }

    public function testUserCanNotEditOtherOrganizations()
    {
        $this->actingAsLoggedInUser();
        $organization = Organization::factory()->create();

        $newInput = ['name' => 'X-Force'];

        $response = $this->put($this->getApiUrl() . '/organizations/' . $organization->uid, $newInput);
        $response->assertStatus(403);
    }

    public function testOrganizationListIsReturned()
    {
        $this->actingAsLoggedInUser();

        $organizations = Organization::factory()->count(2)->create();

        $member = User::factory()->create();

        OrganizationUser::factory()->create(['user_id' => $member->id, 'organization_id' => $organizations[0]->id]);
        $response = $this->get($this->getApiUrl() . '/organizations');

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'name' => $organizations[0]->name,
                    'uid' => $organizations[0]->uid,
                    'is_public' => $organizations[0]->is_public,
                    'members' => [
                        ['username' => $member->username, 'role' => OrganizationUser::ROLE_MEMBER]
                    ]
                ]
            ]]);
    }

    public function testOrganizationListCanBeFilteredByVisibility()
    {

        $organizations = Organization::factory()->count( 2)->create();
        $organizations[0]->is_public = 0;
        $organizations[0]->save();


        $response = $this->get($this->getApiUrl() . '/organizations');
        $response->assertStatus(200)->assertJsonCount(2,'data');

        $response = $this->get($this->getApiUrl() . '/organizations?filter[is_public]=1');
        $response->assertStatus(200)->assertJsonCount(1,'data');

        $response = $this->get($this->getApiUrl() . '/organizations?filter[is_public]=0');
        $response->assertStatus(200)->assertJsonCount(1,'data');
    }

    public function testOrganizationInfoIsReturned()
    {
        $organization = Organization::factory()->create();

        $response = $this->get($this->getApiUrl() . '/organizations/' . $organization->uid);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'name' => $organization->name,
                'uid' => $organization->uid,
                'is_public' => $organization->is_public,
            ]]);
    }

    public function testOnlyMyOrganizationsAreReturned()
    {
        $user = $this->actingAsOrganizationMember();

        $organizations = Organization::factory()->count( 3)->create();
        $organizations[0]->users()->attach($user, ['creator_id' => $user->id]);

        $response = $this->get($this->getApiUrl() . '/organizations?onlyMine=1');

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    1 => [
                        'name' => $organizations[0]->name,
                    ]
                ]
            ]);
        $this->assertCount(2, $response->json('data'));
    }
}
