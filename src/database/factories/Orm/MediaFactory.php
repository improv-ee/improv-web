<?php

namespace Database\Factories\Orm;

use App\Orm\Media;
use App\Orm\Production;

use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        /** @var Production $production */
        $production = Production::factory()->create();

        $production->addMediaFromBase64('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4wEbDCgCXDUMQAAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAAMSURBVAjXY/j//z8ABf4C/tzMWecAAAAASUVORK5CYII=')
            ->toMediaCollection('images');

        /** @var Media $media */
        $media = $production->getMedia('images')->first();

        $values = $media->toArray();
        $media->forceDelete();

        return $values;
    }
}
