<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Orm\Media;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Exceptions\InvalidConversion;
use Spatie\MediaLibrary\Support\PathGenerator\PathGeneratorFactory;

/**
 * @group Images
 */
class ImageController extends Controller
{

    const IMAGE_CACHE_TTL = 2592000;

    /**
     * Get an Image
     *
     * Returns the specified Image. The Content-Type of the response is that of an image (image/png).
     *
     * @response {}
     */
    public function show(string $filename, ?string $conversion = '', ?string $responsive = null)
    {
        /** @var Media $media */
        $media = Media::where('file_name', $filename)->first();

        if ($media === null) {
            return response('', 404);
        }

        if ($responsive && $media->hasResponsiveImages($conversion)) {

            foreach ($media->responsiveImages($conversion)->files as $file) {

                if ($file->fileName !== $responsive) {
                    continue;
                }

                $pathGenerator = PathGeneratorFactory::create();

                $path = $pathGenerator->getPathForResponsiveImages($file->media);

                $fullPath = $path . $responsive;

                return $this->returnMediaResponse($fullPath, $media->mime_type);
            }
        }

        try {
            return $this->returnMediaResponse($media->getPath($conversion), $media->mime_type);
        } catch (FileNotFoundException | InvalidConversion $e) {
            Log::alert($e->getMessage(), ['mediaId' => $media->id, 'path' => $media->getPath()]);
            return response('', 404);
        }

    }

    private function returnMediaResponse(string $mediaFullPath, string $contentType): Response
    {
        $file = Storage::disk('media')->get($mediaFullPath);

        return new Response($file, 200, [
            'Content-Type' => $contentType,
            'Cache-Control' => 'public, max-age=' . self::IMAGE_CACHE_TTL
        ]);
    }
}
