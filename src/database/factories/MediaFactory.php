<?php

use App\Orm\Production;
use Faker\Generator as Faker;
use Spatie\MediaLibrary\Models\Media;

$factory->define(Media::class, function (Faker $faker) {

    /** @var Production $production */
    $production = factory(Production::class)->create();

    $production->addMediaFromBase64('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAIAAACQd1PeAAAACXBIWXMAAC4jAAAuIwF4pT92AAAAB3RJTUUH4wEbDCgCXDUMQAAAABl0RVh0Q29tbWVudABDcmVhdGVkIHdpdGggR0lNUFeBDhcAAAAMSURBVAjXY/j//z8ABf4C/tzMWecAAAAASUVORK5CYII=')
        ->toMediaCollection('images');

    /** @var Media $media */
    $media = $production->getMedia('images')->first();
    $values = $media->toArray();
    $media->delete();

    return $values;
});
