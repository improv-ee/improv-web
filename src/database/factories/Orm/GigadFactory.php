<?php

namespace Database\Factories\Orm;

use App\Orm\Gigad;
use App\Orm\GigCategory;
use App\Orm\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GigadFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Gigad::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'link' => $this->faker->url,
            'description' => $this->faker->sentence(30),
            'organization_id' => Organization::inRandomOrder()->first()->id,
            'gig_category_id' => GigCategory::inRandomOrder()->first()->id,
            'uid' => (string) Str::uuid(),
            'is_public'=>true
        ];
    }
}
