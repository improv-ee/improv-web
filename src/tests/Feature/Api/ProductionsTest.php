<?php

namespace Tests\Feature\Api;

use App\Orm\Event;
use App\Orm\Organization;
use App\Orm\Production;
use App\Orm\Tag;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

/**
 * @package Tests\Feature\Api
 * @covers \App\Http\Controllers\Api\V1\ProductionController
 */
class ProductionsTest extends ApiTestCase
{
    use DatabaseMigrations;

    protected $validProductionInput = [];

    /**
     * @var Production
     */
    protected $production;

    protected function setUp(): void
    {
        parent::setUp();
        $this->production = factory(Production::class)->create();

        $this->validProductionInput = [
            'title' => 'Sad Margarita',
            'tags' => [Tag::first()->slug],
            'organizations' =>  [$this->production->organizations()->first()->uid]
        ];

    }

    /**
     * @return void
     */
    public function testProductionInfoIsReturned()
    {
        $response = $this->get($this->getApiUrl() . '/productions');

        $tag = Tag::first();
        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'title' => $this->production->title,
                    'description' => $this->production->description,
                    'excerpt' => $this->production->excerpt,
                    'organizations' => [
                        [
                            'uid' => $this->production->organizations->first()->uid
                        ]
                    ],
                    'tags' => [
                        [
                            'slug' => $tag->slug,
                            'name' => $tag->name
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
        $this->validProductionInput['organizations'][] = $user->organizations()->first()->uid;

        $response = $this->post($this->getApiUrl() . '/productions', $this->validProductionInput);
        $response->assertStatus(201)
            ->assertJson(['data' => ['title' => $this->validProductionInput['title']]]);

        $this->assertDatabaseHas('production_translations', ['title' => $this->validProductionInput['title']]);
    }


    public function testAddingOrganizationToProductionSavesItInDatabase()
    {
        $user = $this->actingAsOrganizationMember();
        $userOrganization = $user->organizations()->first();
        $newOrganization = factory(Organization::class)->create();

        $this->production->organizations()->attach($userOrganization);

        $input = $this->production->toArray();
        $input['organizations'] = [$userOrganization->uid, $newOrganization->uid];
        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->uid, $input);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'organizations' => [
                    ['uid' => $userOrganization->uid],
                    ['uid' => $newOrganization->uid]
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
            'organizations' => [$user->organizations()->first()->uid, $organization->uid],
            'excerpt' => 'Lots of shows, many nights of fun']);

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->uid, $productionInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['title' => $productionInput['title'],
                'description' => $productionInput['description'],
                'title' => 'Tilt Improv Festival',
                'excerpt' => $productionInput['excerpt']]]);

        $this->assertDatabaseHas('production_translations', ['title' => $productionInput['title']]);
    }

    public function testProductionImageCanBeRemoved()
    {
        $user = $this->actingAsOrganizationMember();
        $this->production->organizations()->attach($user->organizations()->first());

        $productionInput = array_replace($this->validProductionInput, [
            'images' => ['header' => ['content' => null]],
            'organizations' => [$user->organizations()->first()->uid]
        ]);

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->uid, $productionInput);

        $response->assertStatus(200);
        $this->assertCount(0, $this->production->getMedia('images'));
    }


    public function testProductionImageCanBeAdded()
    {
        $user = $this->actingAsOrganizationMember();
        $this->validProductionInput['organizations'] = [$user->organizations()->first()->uid];

        $this->production->organizations()->attach($user->organizations()->first());
        $this->production->getFirstMedia('images')->delete();

        $productionInput = array_replace($this->validProductionInput, ['images' => ['header' => ['content' =>
            base64_encode(UploadedFile::fake()->image('header.jpg', 900, 506)->get())
        ]]]);

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->uid, $productionInput);

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
                $organization->uid
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

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->uid, $productionInput);

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

        $response = $this->delete($this->getApiUrl() . '/productions/' . $this->production->uid);
        $response->assertStatus(403);

    }

    public function testCanDeleteProduction()
    {
        $user = $this->actingAsOrganizationMember();
        $this->production->organizations()->attach($user->organizations()->first());

        $response = $this->delete($this->getApiUrl() . '/productions/' . $this->production->uid);

        $response->assertStatus(200);
    }

    public function testTagsCanBeAddedToExistingProduction()
    {

        $user = $this->actingAsOrganizationMember();
        $this->production->organizations()->attach($user->organizations()->first());

        $tag = Tag::first();

        $productionInput = array_replace($this->validProductionInput, ['title' => 'Tilt Improv Festival',
            'excerpt' => 'Lots of shows, many nights of fun',
            'organizations' => [$user->organizations()->first()->uid],
            'tags' => [$tag->slug]
        ]);

        $response = $this->put($this->getApiUrl() . '/productions/' . $this->production->uid, $productionInput);

        $response->assertStatus(200)
            ->assertJson(['data' => [
                'tags' => [
                    ['name' => $tag->name, 'slug' => $tag->slug]
                ]
            ]]);
    }

    public function testProductionWithoutUpcomingEventsIsMarkedAsWithNoUpcomingEvents()
    {

        Production::truncate();

        $event = factory(Event::class)->create();
        $event->start_time = Carbon::now()->subYear();
        $event->end_time = Carbon::now()->subYear();
        $event->save();

        $response = $this->get($this->getApiUrl() . '/productions');
        $response->assertStatus(200);
        $this->assertFalse($response->json('data.0.hasUpcomingEvents'));
    }


    public function testProductionWithUpcomingEventsIsMarkedAsHavingSome()
    {

        Production::truncate();

        factory(Event::class)->create();

        $response = $this->get($this->getApiUrl() . '/productions');
        $response->assertStatus(200);

        $this->assertTrue($response->json('data.0.hasUpcomingEvents'));
    }

}
