<?php

namespace App\Log;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LogstashFormatter extends \Monolog\Formatter\LogstashFormatter
{
    public function format(array $record)
    {
        $record['extra']['userId'] = Auth::user()->id ?? null;

        if (Request::instance()) {
            $record['extra']['cfRay'] = Request::instance()->header('CF-RAY');
            $record['extra']['requestId'] = Request::instance()->header('X-Request-ID');
            $record['extra']['clientIp'] = Request::ip();
        }

        return parent::format($record);
    }

}