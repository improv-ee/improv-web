<?php

namespace App\Log;

use Illuminate\Http\Request;
use Spatie\HttpLogger\LogProfile;

class LogApiRequests implements LogProfile
{
    public function shouldLogRequest(Request $request): bool
    {
        return in_array(strtolower($request->method()), ['post', 'put', 'patch', 'get', 'delete']);
    }
}
