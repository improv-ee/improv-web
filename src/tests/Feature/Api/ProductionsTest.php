<?php

namespace Tests\Feature;

use App\Orm\Production;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionsTest extends TestCase
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
}
