<?php

namespace Tests\Feature\Api;

use App\Events\Organization\UserJoined;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class OrganizationsTest extends ApiTestCase
{
    use DatabaseMigrations;


    public function testOrganizationCanBeCreated()
    {
        $user = $this->actingAsLoggedInUser();


        $name = 'Justice League';
        $response = $this->post('/api/organizations', [
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

    public function testOrganizationCreatorGetsAdmin(){
        $user = $this->actingAsLoggedInUser();

        $organizationName = 'The Evil League of Evil';
        $response = $this->post('/api/organizations', [
            'name' => $organizationName
        ]);

        $response->assertStatus(201);

        $org = $user->organizations()->first();

        $this->assertEquals($organizationName,$org->name);
        $this->assertEquals(OrganizationUser::ROLE_ADMIN,$org->pivot->role);

    }

    public function testOrganizationWithExistingNameCanNotBeCreated()
    {

        $user = $this->actingAsOrganizationMember();

        $response = $this->post('/api/organizations', [
            'name' => $user->organizations()->first()->name
        ]);

        $response->assertStatus(422);
    }

    public function testOrganizationCanBeEdited()
    {
        $user = $this->actingAsOrganizationMember(OrganizationUser::ROLE_ADMIN);

        $organization=  $user->organizations()->first();

        $newInput = ['name'=> $organization->name, 'description' => 'new description'];

        $response = $this->put('/api/organizations/' . $organization->slug, $newInput);

        $response->assertStatus(200)
            ->assertJson(['data' => ['name' => $newInput['name']]]);

        $this->assertDatabaseHas('organization_translations', ['name'=>$organization->name, 'description' => $newInput['description']]);
    }

    public function testUserCanNotEditOrganizationIfNotAdmin() {
        $this->actingAsLoggedInUser();

        $organization = factory(Organization::class)->create();

        $newInput = ['name' => 'X-Force'];

        $response = $this->put('/api/organizations/' . $organization->slug, $newInput);
        $response->assertStatus(403);
    }

    public function testOrganizationListIsReturned()
    {
        $this->actingAsLoggedInUser();

        $organizations = factory(Organization::class, 2)->create();
        $member = factory(User::class)->create();

        OrganizationUser::create(['user_id' => $member->id, 'organization_id' => $organizations[0]->id]);

        $response = $this->get('/api/organizations');

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

        $response = $this->get('/api/organizations/' . $organization->slug);

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
        $organizations[0]->users()->attach($user);

        $response = $this->get('/api/organizations?onlyMine=1');

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
