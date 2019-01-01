<?php

namespace Tests\Feature\Api;

use App\Orm\Organization;
use App\Orm\Production;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class ProductionsTest
 * @package Tests\Feature\Api
 * @covers \App\Http\Controllers\Api\ProductionController
 */
class ProductionsTest extends ApiTestCase
{
    use DatabaseMigrations;

    protected $validProductionInput = [
        'title' => 'Sad Margarita',
        'organizations' => []
    ];

    /**
     * @var Production
     */
    protected $production;

    public function setUp()
    {
        parent::setUp();
        $this->production = factory(Production::class)->create();
        $this->validProductionInput['organizations'] = [$this->production->organizations()->first()->slug];
    }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProductionInfoIsReturned()
    {

        $response = $this->get('/api/productions');

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'title' => $this->production->title,
                    'description' => $this->production->description,
                    'excerpt' => $this->production->excerpt,
                    'organizations' => [
                        [
                            'slug' => $this->production->organizations->first()->slug
                        ]
                    ]
                ]
            ]]);
    }

    public function testOnlyProductionsBelongingToMyOrganizationsAreReturned()
    {
        $user = $this->actingAsOrganizationMember();
        $organization = $user->organizations()->first();

        $otherOrganization = factory(Organization::class)->create();
        $productions = factory(Production::class, 10)->create();

        $productions[1]->organizations()->attach($organization);
        $productions[2]->organizations()->attach($otherOrganization);
        $productions[4]->organizations()->attach($organization);

        $response = $this->get('/api/productions?onlyMine=true');

        $response->assertStatus(200)->assertJsonCount(2, 'data')
            ->assertJson(['data' => [
                [
                    'title' => $productions[1]->title,
                ],
                [
                    'title' => $productions[4]->title
                ]
            ]]);
    }

    public function testProductionCanBeCreated()
    {
        $this->actingAsOrganizationMember();

        $response = $this->post('/api/productions', $this->validProductionInput);
        $response->assertStatus(201)
            ->assertJson(['data' => ['title' => $this->validProductionInput['title'], 'slug' => 'sad-margarita']]);

        $this->assertDatabaseHas('production_translations', ['title' => $this->validProductionInput['title']]);
    }


    public function testAddingOrganizationToProductionSavesItInDatabase()
    {
        $user = $this->actingAsOrganizationMember();
        $userOrganization = $user->organizations()->first();
        $newOrganization = factory(Organization::class)->create();

        $this->production->organizations()->attach($userOrganization);

        $input = $this->production->toArray();
        $input['organizations'] = [$userOrganization->slug, $newOrganization->slug];
        $response = $this->put('/api/productions/' . $this->production->slug, $input);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'organizations' => [
                    ['slug' => $userOrganization->slug],
                    ['slug' => $newOrganization->slug]
                ]
            ]]);

        $this->assertDatabaseHas('organization_production', ['organization_id' => $newOrganization->id, 'production_id' => $this->production->id]);
        $this->assertDatabaseHas('organization_production', ['organization_id' => $userOrganization->id, 'production_id' => $this->production->id]);
    }


    public function testProductionCanBeEdited()
    {
        $user = $this->actingAsOrganizationMember();


        $this->production->organizations()->attach($user->organizations()->first());

        $productionInput = array_replace($this->validProductionInput, ['title' => 'Tilt Improv Festival',
            'description' => 'First improv festival in Estonia',
            'excerpt' => 'Lots of shows, many nights of fun']);

        $response = $this->put('/api/productions/' . $this->production->slug, $productionInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['title' => $productionInput['title'],
                'description' => $productionInput['description'],
                'slug' => 'tilt-improv-festival',
                'excerpt' => $productionInput['excerpt']]]);

        $this->assertDatabaseHas('production_translations', ['title' => $productionInput['title']]);
    }

    public function testCanNotEditProductionNotOwnedByMyOrganization()
    {
        $this->actingAsOrganizationMember();

        $productionInput = ['title' => 'Tilt Improv Festival',
            'description' => 'First improv festival in Estonia',
            'excerpt' => 'Lots of shows, many nights of fun'];

        $response = $this->put('/api/productions/' . $this->production->slug, $productionInput);

        $response->assertStatus(403);
    }

    public function testCreatingProductionWithInvalidInputFails()
    {
        $this->actingAsOrganizationMember();

        $response = $this->post('/api/productions', ['title' => '']);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The given data was invalid.']);
    }

    public function testCanNotDeleteProductionNotOwnedByMyOrganizations()
    {
        $this->actingAsOrganizationMember();

        $response = $this->delete('/api/productions/' . $this->production->slug);
        $response->assertStatus(403);

    }

    public function testCanDeleteProduction()
    {
        $user = $this->actingAsOrganizationMember();
        $this->production->organizations()->attach($user->organizations()->first());

        $response = $this->delete('/api/productions/' . $this->production->slug);

        $response->assertStatus(200);
    }
}
