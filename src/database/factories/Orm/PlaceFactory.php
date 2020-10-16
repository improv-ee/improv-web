<?php

namespace Database\Factories\Orm;

use App\Orm\Place;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlaceFactory extends Factory
{
    protected $model = Place::class;

    public function definition()
    {
        return [
            'uid' => $this->faker->uuid
        ];
    }
}

