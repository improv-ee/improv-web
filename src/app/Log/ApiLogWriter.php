<?php

namespace App\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\HttpLogger\LogWriter;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ApiLogWriter implements LogWriter
{
    public function logRequest(Request $request)
    {
        $method = strtoupper($request->getMethod());

        $uri = $request->getPathInfo();

        $files = array_map(function (UploadedFile $file) {
            return $file->getClientOriginalName();
        }, iterator_to_array($request->files));

        Log::channel('api')->info($uri, [
            'files' => $files,
            'clientIp' => $request->ip(),
            'method' => $method,
            'isAjax' => $request->ajax(),
            'host' =>$request->getHttpHost(),
            'fingerprint' => $request->fingerprint(),
            'language' => $request->getPreferredLanguage(),
            'cfRay' => $request->header('CF-RAY'),
            'requestId' => $request->header('X-Request-ID'),
            'forwarded-for' => $request->header('X-Original-Forwarded-For'),
            'country' => $request->header('CF-IPCountry'),
            'user-agent' => $request->userAgent(),
            'user' => Auth::user()->id ?? null
        ]);
    }
}
