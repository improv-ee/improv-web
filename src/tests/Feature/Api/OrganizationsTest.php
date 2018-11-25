<?php

namespace Tests\Feature\Api;

use App\Events\Organization\UserJoined;
use App\Orm\Organization;
use App\Orm\OrganizationUser;
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

    public function testOrganizationCanBeEdited()
    {
        $this->actingAsOrganizationMember();
        $organization = factory(Organization::class)->create();

        $newInput = ['name' => 'X-Force'];

        $response = $this->put('/api/organizations/' . $organization->slug, $newInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['name' => $newInput['name']]]);

        $this->assertDatabaseHas('organization_translations', ['name' => $newInput['name']]);
    }

    public function testOrganizationListIsReturned()
    {
        $organizations = factory(Organization::class, 2)->create();
        $response = $this->get('/api/organizations');

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'name' => $organizations[0]->name,
                    'slug' => $organizations[0]->slug,
                    'is_public' => $organizations[0]->is_public
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
                'is_public' => $organization->is_public
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


    public function testCanApplyToJoinOrganization()
    {
        $user = $this->actingAsLoggedInUser();

        $organization = factory(Organization::class)->create();

        $response = $this->post(sprintf('/api/organizations/%s/join', $organization->slug));

        $response->assertStatus(201);

        $this->assertDatabaseHas('organization_user', [
            'user_id' => $user->id,
            'organization_id' => $organization->id,
            'role' => OrganizationUser::ROLE_JOINER]);
    }

    public function testCanNotJoinOrganizationTwice()
    {
        $user = $this->actingAsOrganizationMember();
        $org = $user->organizations()->first();

        $this->assertDatabaseHas('organization_user', ['user_id' => $user->id, 'organization_id' => $org->id]);

        $response = $this->post(sprintf('/api/organizations/%s/join', $org->slug));

        $response->assertStatus(400)
            ->assertJsonStructure(['errors' => []]);
    }

    public function testEventIsCreatedOnOrganizationJoin(){
        $this->actingAsLoggedInUser();

        $organization = factory(Organization::class)->create();

        Event::fake();

        $this->post(sprintf('/api/organizations/%s/join', $organization->slug));

        Event::assertDispatched(UserJoined::class, function ($e) use ($organization) {
            return $e->organizationUser->organization_id === $organization->id;
        });
    }
}
