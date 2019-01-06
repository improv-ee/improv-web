<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ImageResource;
use App\Orm\Image;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Spatie\LaravelImageOptimizer\Facades\ImageOptimizer;

/**
 * Class ImageController
 *
 */
class ImageController extends Controller
{

    /**
     * Mocked, needs to exists for tests/apidoc
     *
     * @param $id
     * @return null
     */
    public function show($id)
    {
        $file = Storage::disk('images')->get('images/' . $id);

        $finfo = finfo_open();
        $mimeType = finfo_buffer($finfo, $file, FILEINFO_MIME_TYPE);
        finfo_close($finfo);

        return Response::create($file, 200, ['Content-Type' => $mimeType]);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     *
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
