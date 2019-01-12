<?php

namespace Tests\Feature\Api;

use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class OrganizationsTest extends ApiTestCase
{
    use DatabaseMigrations;


    public function testOrganizationsListCanBeFilteredByName()
    {
        factory(Organization::class)->create(['name' => 'Ruutu10 team nr 1' ]);
        factory(Organization::class)->create(['name' => 'Ruutu10 team nr 2']);
        factory(Organization::class)->create(['name' => 'Ruutu10 majatiim']);
        factory(Organization::class, 10)->create();

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
            ->assertJson(['data' => ['name' => $name, 'is_public' => false, 'slug' => 'justice-league']]);

        $this->assertDatabaseHas('organization_translations', [
            'name' => $name,
            'slug' => 'justice-league'
        ]);
        $this->assertDataBaseHas('organizations', ['creator_id' => $user->id, 'is_public' => 0]);
    }

    public function testOrganizationCanBeDeleted()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);
        $organization = $user->organizations()->first();
        $this->assertNull($organization->deleted_at);

        $response = $this->delete($this->getApiUrl() . '/organizations/' . $organization->slug);
        $response->assertStatus(200);

        $organization->refresh();
        $this->assertNotNull($organization->deleted_at);
    }

    public function testOrganizationCanNotBeDeletedByNonMember()
    {
        $this->actingAsLoggedInUser();
        $organization = factory(Organization::class)->create();

        $response = $this->delete($this->getApiUrl() . '/organizations/' . $organization->slug);
        $response->assertStatus(403);

    }

    public function testOrganizationCanNotBeDeletedByNonAdmin()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_MEMBER);
        $organization = $user->organizations()->first();

        $response = $this->delete($this->getApiUrl() . '/organizations/' . $organization->slug);
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

        $response = $this->put($this->getApiUrl() . '/organizations/' . $organization->slug, $newInput);

        $response->assertStatus(200)
            ->assertJson(['data' => ['name' => $newInput['name']]]);

        $this->assertDatabaseHas('organization_translations', ['name' => $organization->name, 'description' => $newInput['description']]);
        $this->assertDatabaseHas('organizations', ['is_public' => 1, 'id' => $organization->id]);
    }

    public function testUserCanNotEditOrganizationIfNotAdmin()
    {
        $user = $this->actingAsOrganizationMember();
        $organization = $user->organizations()->first();

        $newInput = ['name' => 'X-Force'];

        $response = $this->put($this->getApiUrl() . '/organizations/' . $organization->slug, $newInput);
        $response->assertStatus(403);
    }

    public function testUserCanNotEditOtherOrganizations()
    {
        $this->actingAsLoggedInUser();
        $organization = factory(Organization::class)->create();

        $newInput = ['name' => 'X-Force'];

        $response = $this->put($this->getApiUrl() . '/organizations/' . $organization->slug, $newInput);
        $response->assertStatus(403);
    }

    public function testOrganizationListIsReturned()
    {
        $this->actingAsLoggedInUser();

        $organizations = factory(Organization::class, 2)->create();
        $organizations[0]->name = 'Dragons';
        $organizations[0]->save();
        $organizations[1]->name = 'Vampires';
        $organizations[1]->save();

        $member = factory(User::class)->create();

        factory(OrganizationUser::class)->create(['user_id' => $member->id, 'organization_id' => $organizations[0]->id]);
        $response = $this->get($this->getApiUrl() . '/organizations');

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'name' => $organizations[0]->name,
                    'slug' => $organizations[0]->slug,
                    'is_public' => $organizations[0]->is_public,
                    'members' => [
                        ['username' => $member->username, 'role' => OrganizationUser::ROLE_MEMBER]
                    ]
                ]
            ]]);
    }

    public function testOrganizationInfoIsReturned()
    {
        $organization = factory(Organization::class)->create();

        $response = $this->get($this->getApiUrl() . '/organizations/' . $organization->slug);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'name' => $organization->name,
                'slug' => $organization->slug,
                'is_public' => $organization->is_public,
            ]]);
    }

    public function testOnlyMyOrganizationsAreReturned()
    {
        $user = $this->actingAsOrganizationMember();

        $organizations = factory(Organization::class, 3)->create();
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
