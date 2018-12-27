<?php

namespace Tests\Feature\Api;

use App\Orm\Organization;
use App\Orm\Production;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ProductionsTest extends ApiTestCase
{
    use DatabaseMigrations;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testProductionInfoIsReturned()
    {
        $production = factory(Production::class)->create();

        $response = $this->get('/api/productions');

        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'title' => $production->title,
                    'description' => $production->description,
                    'excerpt' => $production->excerpt
                ]
            ]]);
    }

    public function testOnlyProductionBelongingToMyOrganizationsAreReturned()
    {
        $user = $this->actingAsOrganizationMember();
        $organization = $user->organizations()->first();

        $otherOrganization = factory(Organization::class)->create();

        $productions = factory(Production::class, 10)->create()->getDictionary();
        $productions[1]->organizations()->attach($organization);
        $productions[2]->organizations()->attach($otherOrganization);
        $productions[4]->organizations()->attach($organization);

        $response = $this->get('/api/productions?onlyMine=true');

        $response->assertStatus(200)->assertJsonCount(2,'data')
            ->assertJson(['data' => [
                [
                    'title' => $productions[1]->title,
                ],
                [
                    'title'=>$productions[4]->title
                ]
            ]]);
    }

    public function testProductionCanBeCreated()
    {
        $this->actingAsOrganizationMember();

        $response = $this->post('/api/productions', ['title' => 'Sad Margarita']);
        $response->assertStatus(201)
            ->assertJson(['data' => ['title' => 'Sad Margarita', 'slug' => 'sad-margarita']]);

        $this->assertDatabaseHas('production_translations', ['title' => 'Sad Margarita']);
    }

    public function testProductionCanBeEdited()
    {
        $this->actingAsOrganizationMember();
        $production = factory(Production::class)->create();
        $productionInput = ['title' => 'Tilt Improv Festival',
            'description' => 'First improv festival in Estonia',
            'excerpt' => 'Lots of shows, many nights of fun'];

        $response = $this->put('/api/productions/' . $production->slug, $productionInput);
        $response->assertStatus(200)
            ->assertJson(['data' => ['title' => $productionInput['title'],
                'description' => $productionInput['description'],
                'slug' => 'tilt-improv-festival',
                'excerpt' => $productionInput['excerpt']]]);

        $this->assertDatabaseHas('production_translations', ['title' => $productionInput['title']]);
    }

    public function testCreatingProductionWithInvalidInputFails()
    {
        $this->actingAsOrganizationMember();

        $response = $this->post('/api/productions', ['title' => '']);
        $response->assertStatus(422)
            ->assertJson(['message' => 'The given data was invalid.']);
    }
}
