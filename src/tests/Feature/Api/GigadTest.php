<?php

namespace Tests\Feature\Api;

use App\Orm\Gigad;
use App\Orm\GigCategory;
use App\Orm\Organization;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @covers \App\Http\Controllers\Api\V1\GigadController
 * @package Tests\Feature\Api
 */
class GigadTest extends ApiTestCase
{
    use DatabaseMigrations;

    private Gigad $gigad;
    private array $validGigadInput;

    protected function setUp(): void
    {
        parent::setUp();
        GigCategory::factory()->create();
        Organization::factory()->create();
        $this->gigad = Gigad::factory()->create();
        $this->validGigadInput = [
            'link' => 'http://sqroot.eu/test',
            'description' => 'Lorem ipsum',
            'gig_category_id' => GigCategory::first()->id,
            'is_public' => false
        ];
    }


    public function testGigadInfoIsReturned()
    {

        $adDescription = 'Making audience laugh';
        $this->gigad->description = $adDescription;
        $this->gigad->save();

        $response = $this->get($this->getApiUrl() . '/gigads/' . $this->gigad->uid);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'uid' => $this->gigad->uid,
                'description' => $adDescription,
                'link' => $this->gigad->link,
                'organization' => [
                    'uid' => $this->gigad->organization->uid,
                    'name' => $this->gigad->organization->name
                ],
                'category' => [
                    'name' => $this->gigad->category->name,
                    'id' => $this->gigad->category->id
                ]
            ]]);
    }

    public function testGigadInfoIsListed()
    {
        Gigad::factory()->count(2)->create();

        $response = $this->get($this->getApiUrl() . '/gigads');

        $response->assertStatus(200)
            ->assertJsonFragment([
                'uid' => $this->gigad->uid,
                'description' => $this->gigad->description
            ])
            ->assertJsonCount(3);
    }

    public function testOnlyMyAdsAreListedWhenRequested()
    {
        Gigad::factory()->count(2)->create();

        $user = $this->actingAsOrganizationMember();

        $this->gigad->organization_id = $user->organizations()->first()->id;
        $this->gigad->save();

        $response = $this->get($this->getApiUrl() . '/gigads?onlyMine=1');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'uid' => $this->gigad->uid,
            ])
            ->assertJsonCount(1, 'data');
    }

    public function testOnlyPublicAdsAreListedWhenRequested()
    {
        Gigad::factory()->create(['is_public' => false]);

        $response = $this->get($this->getApiUrl() . '/gigads?filter[is_public]=1');
        $response->assertStatus(200)
            ->assertJsonFragment([
                'uid' => $this->gigad->uid,
            ])
            ->assertJsonCount(1, 'data');
    }

    public function testAdsCanBeFilteredPerOrganization()
    {
        Organization::factory()->count(5)->create();
        Gigad::factory()->count(4)->create();

        $org2 = Organization::factory()->create();
        $ad2 = Gigad::factory()->create(['organization_id' => $org2->id]);
        $ad3 = Gigad::factory()->create(['organization_id' => $org2->id]);

        $response = $this->get($this->getApiUrl() . '/gigads?filter[organization.uid]=' . $org2->uid);
        $response->assertStatus(200)
            ->assertJsonFragment([
                'uid' => $ad3->uid,
            ])->assertJsonFragment([
                'uid' => $ad2->uid,
            ])
            ->assertJsonCount(2, 'data');
    }


    public function testGigadCanBeCreated()
    {
        $user = $this->actingAsOrganizationMember();

        $this->validGigadInput['organization_uid'] = $user->organizations()->first()->uid;

        $response = $this->post($this->getApiUrl() . '/gigads/', $this->validGigadInput);

        $response->assertStatus(201)
            ->assertJson(['data' => ['link' => $this->validGigadInput['link']]]);

        $this->assertDatabaseHas('gigad_translations', ['link' => $this->validGigadInput['link']]);
    }

    public function testGigadCanBeEdited()
    {
        $user = $this->actingAsOrganizationMember();

        $this->gigad->organization_id = $user->organizations()->first()->id;
        $this->gigad->save();
        $this->validGigadInput['organization_uid'] = $user->organizations()->first()->uid;

        $response = $this->put($this->getApiUrl() . '/gigads/' . $this->gigad->uid, $this->validGigadInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['link' => $this->validGigadInput['link']]]);
    }

    public function testAdBelongingToOtherOrganizationCanNotBeEdited()
    {
        $this->actingAsOrganizationMember();

        $otherOrg = Organization::factory()->create();
        $this->gigad->organization_id = $this->validGigadInput['organization_uid'] = $otherOrg->id;
        $this->gigad->save();

        $response = $this->put($this->getApiUrl() . '/gigads/' . $this->gigad->uid, $this->validGigadInput);
        $response->assertStatus(403);
    }

    public function testAdCanBeDeleted()
    {
        $user = $this->actingAsOrganizationMember();

        $this->gigad->organization_id = $user->organizations()->first()->id;
        $this->gigad->save();

        $response = $this->delete($this->getApiUrl() . '/gigads/' . $this->gigad->uid);
        $response->assertStatus(200);

        $this->gigad->refresh();
        $this->assertNotNull($this->gigad->deleted_at);
    }


    public function testAdBelongingToOtherOrganizationCanNotBeDeleted()
    {
        $this->actingAsOrganizationMember();

        $otherOrg = Organization::factory()->create();
        $this->gigad->organization_id = $this->validGigadInput['organization_uid'] = $otherOrg->id;
        $this->gigad->save();

        $response = $this->delete($this->getApiUrl() . '/gigads/' . $this->gigad->uid);
        $response->assertStatus(403);
    }
}
