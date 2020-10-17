<?php

namespace App\Orm\Traits;

use Spatie\Image\Manipulations;

/**
 * Trait to register a Spatie media-library conversion for objects that have a 'cover' image type
 *
 * @package App\Orm\Traits
 */
trait HasCoverImage
{
    /**
     * https://spatie.be/docs/laravel-medialibrary/v8/converting-images/defining-conversions
     */
    protected function registerCoverImageConversion()
    {
        $this->addMediaConversion('cover')
            ->fit(
                Manipulations::FIT_CROP,
                config('improv.images.header.width.optimal'),
                config('improv.images.header.height.optimal')
            );
    }
}
