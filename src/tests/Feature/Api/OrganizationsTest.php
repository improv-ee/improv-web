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
        $this->actingAsLoggedInUser();

        $organizations = factory(Organization::class, 2)->create();
        $member = factory(User::class)->create();

        OrganizationUser::create(['user_id'=>$member->id,'organization_id'=>$organizations[0]->id]);

        $response = $this->get('/api/organizations');

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'name' => $organizations[0]->name,
                    'slug' => $organizations[0]->slug,
                    'is_public' => $organizations[0]->is_public,
                    'members' => [

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
