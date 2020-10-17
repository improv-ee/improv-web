<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Orm\Media;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidConversion;

/**
 * @group Images
 */
class ImageController extends Controller
{

    /**
     * Get an Image
     *
     * Returns the specified Image. The Content-Type of the response is that of an image (image/png).
     *
     * @response {}
     */
    public function show($filename)
    {
        /** @var \App\Orm\Media $media */
        $media = Media::where('file_name', $filename)->first();

        if ($media === null) {
            return response('', 404);
        }

        try {
            $file = Storage::disk('media')->get($media->getPath('cover'));
        } catch (FileNotFoundException | InvalidConversion $e) {
            Log::alert($e->getMessage(), ['mediaId' => $media->id, 'path' => $media->getPath()]);
            $file = stream_get_contents($media->getDefaultCoverImageStream());
        }

        return new Response($file, 200, [
            'Content-Type' => $media->mime_type,
            'Cache-Control' => 'public, max-age=2592000',
            'ETag' => $media->getHash()
        ]);
    }
}
