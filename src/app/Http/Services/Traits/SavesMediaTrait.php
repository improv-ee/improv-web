<?php

namespace App\Http\Services\Traits;

use \Spatie\MediaLibrary\HasMedia;
use Illuminate\Http\Request;

trait SavesMediaTrait
{
    protected function addMedia($base64Media, HasMedia $model)
    {
        $model->addMediaFromBase64($base64Media)
            ->withCustomProperties(['type' => 'header'])
            ->setFileName($this->getFileName())
            ->toMediaCollection('images');
    }

    /**
     * Get a unique pseudo-random file name
     *
     * @return string
     */
    protected function getFileName(): string
    {
        try {
            $seed = random_int(PHP_INT_MIN, PHP_INT_MAX) . uniqid();
        } catch (\Exception $e) {
            $seed = uniqid('', true) . '-' . time();
        }

        return sha1($seed);
    }

    /**
     * @param HasMedia $model
     */
    protected function removeAllMedia(HasMedia $model)
    {
        foreach ($model->getMedia('images') as $media) {
            $media->delete();
        }
    }


    /**
     * @param Request $request
     * @param HasMedia $model
     */
    protected function syncMedia(Request $request, HasMedia $model)
    {
        $media = $request->input('images.header.content', false);

        // Remove existing Media if it's explicitly requested, or
        // if we want to replace it with a new image
        if ($media === null || $media) {
            $this->removeAllMedia($model);
        }

        // If new media content was uploaded..
        if ($media) {
            $this->addMedia($media, $model);
        }
    }
}
