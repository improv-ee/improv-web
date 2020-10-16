<?php
namespace Database\Factories\Orm;

use App\Orm\Organization;
use App\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrganizationFactory extends Factory {
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Organization::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::factory()->create();

        return [
            'name' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(30),
            'creator_id' => $user->id,
            'is_public' => true,
            'email' => $this->faker->email,
            'homepage_url'=>$this->faker->url,
            'facebook_url'=>$this->faker->url
        ];
    }
}

