<?php

namespace Tests\Feature;

use App\Orm\Production;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductionTest extends TestCase
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
        $user = $this->actingAsOrganizationMember();
        $production = factory(Production::class)->create();

        $response = $this->put('/api/productions/'.$production->slug, ['title'=>'Sad Margarita']);
        $response->assertStatus(200)
            ->assertJson(['data' => ['title' => 'Sad Margarita',
                'description'=>$production->description]]);

        $this->assertDatabaseHas('production_translations',['title'=>'Sad Margarita']);
    }

    public function testProductionCanBeEdited(){
         $this->actingAsOrganizationMember();

        $productionInput = ['title' => 'Tilt Improv Festival',
            'description' => 'First improv festival in Estonia',
            'excerpt' => 'Lots of shows, many nights of fun'];

        $response = $this->post('/api/productions', $productionInput);
        $response->assertStatus(201)
            ->assertJson(['data' => ['title' => 'Tilt Improv Festival',
                'slug'=>'tilt-improv-festival']]);
    }
}
