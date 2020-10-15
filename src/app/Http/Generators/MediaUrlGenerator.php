<?php

namespace App\Http\Generators;

use DateTimeInterface;
use App\Orm\Media;
use Spatie\MediaLibrary\Support\UrlGenerator\DefaultUrlGenerator;

/**
 * @package App\Http\Generators
 * @property Media $media
 */
class MediaUrlGenerator extends DefaultUrlGenerator
{

    /**
     * Get the url for a media item.
     *
     * @return string
     */
    public function getUrl(): string
    {
        return route('api.images.show', ['image' => $this->media->file_name]).'?hash='.$this->media->getHash();
    }

    public function getPath(): string
    {
        if (env('APP_ENV') !== 'testing') {
            throw new \Exception('MediaUrlGenerator::getPath not implemented outside testing env');
        }
        return storage_path('framework/testing/');
    }

    /**
     * Get the temporary url for a media item.
     *
     * @param DateTimeInterface $expiration
     * @param array $options
     *
     * @return string
     */
    public function getTemporaryUrl(DateTimeInterface $expiration, array $options = []): string
    {
        return '';
    }

    /**
     * Get the url to the directory containing responsive images.
     *
     * @return string
     */
    public function getResponsiveImagesDirectoryUrl(): string
    {
        return '';
    }
}
