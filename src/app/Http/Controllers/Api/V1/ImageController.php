<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ImageResource;
use App\Orm\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

/**
 * Class ImageController
 * @group Images
 *
 */
class ImageController extends Controller
{

    /**
     * Get an Image
     *
     * Returns the specified Image. The Content-Type of the response is that of an image (image/png).
     *
     * @param $id
     * @return null
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @response {}
     */
    public function show($id)
    {

        if (!Storage::disk('images')->exists('images/' . $id)){
            return response('',404);
        }

        $file = Storage::disk('images')->get('images/' . $id);

        $finfo = finfo_open();
        $mimeType = finfo_buffer($finfo, $file, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        return Response::create($file, 200, ['Content-Type' => $mimeType]);

    }

    /**
     * Save a new Image
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     * @authenticated
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => ['required', Rule::dimensions()->minWidth(400)->minHeight(300)->maxHeight(2000)->maxWidth(2000)]
        ]);

        $originalFileName = $request->file('image')->getClientOriginalName();

        $path = $request->file('image')->store('', ['disk' => 'local']);

        $prefix = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix();

        ImageOptimizer::optimize($prefix . $path);
        $contents = Storage::disk('local')->readStream($path);

        $uid = sha1(random_int(PHP_INT_MIN,PHP_INT_MAX).uniqid());
        $path = Storage::disk('images')->put('images/' . $uid, $contents, ['disk' => 'images', 'visibility' => 'private']);

        Storage::disk('local')->delete($path);


        $image = new Image;
        $image->uid = $uid;
        $image->creator_id = $request->user()->id;
        $image->filename = $originalFileName;
        $image->save();

        return response(new ImageResource($image), 201);
    }


}
