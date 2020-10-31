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
            )
            ->withResponsiveImages()

            // Do not perform image conversion using a queue and a worker, instead
            // do it synchronously in the main webserver container. This is bad for performance,
            // but currently needed UX workaround - users who upload a cover image want to see the
            // potentially cropped image immediately after; to avoid confusion and surprise should the
            // originally uploaded image then suddenly change later. To change this if performance hit
            // becomes too big of a problem
            ->nonQueued();
    }
}
