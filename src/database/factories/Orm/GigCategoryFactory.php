<?php

namespace Database\Factories\Orm;

use App\Orm\GigCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class GigCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GigCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(30, true)
        ];
    }
}
