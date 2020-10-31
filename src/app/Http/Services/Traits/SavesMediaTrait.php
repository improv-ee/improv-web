<?php

namespace App\Http\Services\Traits;

use \Spatie\MediaLibrary\HasMedia;
use Illuminate\Http\Request;

trait SavesMediaTrait
{
    protected function addMedia($base64Media, HasMedia $model)
    {
        $model->addMediaFromBase64($base64Media)
            ->withResponsiveImages()
            ->withCustomProperties(['type' => 'header'])
            ->toMediaCollection('images');
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
