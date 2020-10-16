<?php

namespace Database\Factories\Orm;

use App\Orm\Organization;
use App\Orm\Production;
use App\Orm\Tag;
use App\User;
use Illuminate\Support\Facades\App;
use Illuminate\Database\Eloquent\Factories\Factory;


class ProductionFactory extends Factory
{
    protected $model = Production::class;

    public function definition()
    {
        $user = User::factory()->create();

        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(100),
            'excerpt' => $this->faker->sentence(10),
            'creator_id' => $user->id
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Production $production) {
            $organization = Organization::factory()->create();
            $production->organizations()->attach($organization);

            // Use a dummy base64 picture for unit tests, but download a larger fancier picture for local dev env
            if (App::environment('testing')) {
                $media = $production->addMediaFromBase64('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4wEbDCgCXDUMQAAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAAMSURBVAjXY/j//z8ABf4C/tzMWecAAAAASUVORK5CYII=');
            } else {
                $media = $production->addMediaFromUrl('https://placekitten.com/600/400');
            }

            $media->toMediaCollection('images');

            $production->attachTag(Tag::first());
        });
    }
}
