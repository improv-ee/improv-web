<?php

namespace Tests\Feature\Api;

use App\Orm\Organization;
use App\Orm\Production;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;

/**
 * @package Tests\Feature\Api
 * @covers \App\Http\Controllers\Api\V1\ProductionController
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
        $response = $this->get($this->getApiUrl() . '/productions');

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

        $response = $this->get($this->getApiUrl() . '/productions?onlyMine=true');

        $response->assertStatus(200)->assertJsonCount(2, 'data')
            ->assertJsonCount(2, 'data');
    }

    public function testProductionCanBeCreated()
    {
        $user = $this->actingAsOrganizationMember();
        $this->validProductionInput['organizations'][] = $user->organizations()->first()->slug;

        $response = $this->post($this->getApiUrl() . '/productions', $this->validProductionInput);
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
        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->slug, $input);

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

        $organization = factory(Organization::class)->create();

        $productionInput = array_replace($this->validProductionInput, ['title' => 'Tilt Improv Festival',
            'description' => 'First improv festival in Estonia',
            'organizations' => [$user->organizations()->first()->slug, $organization->slug],
            'excerpt' => 'Lots of shows, many nights of fun']);

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->slug, $productionInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['title' => $productionInput['title'],
                'description' => $productionInput['description'],
                'slug' => 'tilt-improv-festival',
                'excerpt' => $productionInput['excerpt']]]);

        $this->assertDatabaseHas('production_translations', ['title' => $productionInput['title']]);
    }

    public function testProductionImageCanBeRemoved()
    {
        $user = $this->actingAsOrganizationMember();
        $this->production->organizations()->attach($user->organizations()->first());

        $productionInput = array_replace($this->validProductionInput, [
            'images' => ['header' => ['content' => null]],
            'organizations'=>[$user->organizations()->first()->slug]
        ]);

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->slug, $productionInput);

        $response->assertStatus(200);
        $this->assertCount(0, $this->production->getMedia('images'));
    }


    public function testProductionImageCanBeAdded()
    {
        $user = $this->actingAsOrganizationMember();
        $this->validProductionInput['organizations'] = [$user->organizations()->first()->slug];

        $this->production->organizations()->attach($user->organizations()->first());
        $this->production->getFirstMedia('images')->delete();

        $productionInput = array_replace($this->validProductionInput, ['images' => ['header' => ['content' =>
            base64_encode(UploadedFile::fake()->image('header.jpg', 900, 506)->get())
        ]]]);

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->slug, $productionInput);

        $response->assertStatus(200);
        $this->assertCount(1, $this->production->getMedia('images'));
        $this->assertEquals('image/png', $this->production->getFirstMedia('images')->mime_type);
    }

    /**
     * Should not be able to create Productions for "other" Organizations
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function testProductionCreationFailsIfDoesntBelongToMyOrganization()
    {
        $this->actingAsOrganizationMember();
        $organization = factory(Organization::class)->create();

        $productionInput = array_replace($this->validProductionInput, [
            'organizations' => [
                $organization->slug
            ]
        ]);

        $response = $this->post($this->getApiUrl() . '/productions', $productionInput);
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['organizations']);
    }

    public function testCanNotEditProductionNotOwnedByMyOrganization()
    {
        $this->actingAsOrganizationMember();

        $productionInput = ['title' => 'Tilt Improv Festival',
            'description' => 'First improv festival in Estonia',
            'excerpt' => 'Lots of shows, many nights of fun'];

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->slug, $productionInput);

        $response->assertStatus(403);
    }

    public function testCreatingProductionWithInvalidInputFails()
    {
        $this->actingAsOrganizationMember();

        $response = $this->post($this->getApiUrl() . '/productions', ['title' => '']);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The given data was invalid.']);
    }

    public function testCanNotDeleteProductionNotOwnedByMyOrganizations()
    {
        $this->actingAsOrganizationMember();

        $response = $this->delete($this->getApiUrl() . '/productions/' . $this->production->slug);
        $response->assertStatus(403);

    }

    public function testCanDeleteProduction()
    {
        $user = $this->actingAsOrganizationMember();
        $this->production->organizations()->attach($user->organizations()->first());

        $response = $this->delete($this->getApiUrl() . '/productions/' . $this->production->slug);

        $response->assertStatus(200);
    }
}
