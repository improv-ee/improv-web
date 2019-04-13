<?php

use Monolog\Handler\StreamHandler;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['daily'],
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
        ],

        // Application log
        'daily' => [
            'driver' => 'monolog',
            'handler' => \Monolog\Handler\RotatingFileHandler::class,
            'handler_with' => [
                'filename' => storage_path('logs/laravel.log'),
                'maxFiles' => 7
            ],
            'formatter' => \Monolog\Formatter\LogstashFormatter::class,
            'formatter_with' => [
                'applicationName' => 'improv-web',
                'contextPrefix' => ''
            ],
        ],

        // Api request log
        'api' => [
            'driver' => 'monolog',
            'handler' => \Monolog\Handler\RotatingFileHandler::class,
            'handler_with' => [
                'filename' => storage_path('logs/api.log'),
                'maxFiles' => 7
            ],
            'formatter' => \Monolog\Formatter\LogstashFormatter::class,
            'formatter_with' => [
                'applicationName' => 'improv-api',
                'contextPrefix' => ''
            ],
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => 'critical',
        ],

        'stderr' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],
        'stdout' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'with' => [
                'stream' => 'php://stdout',
            ],
        ],
        'syslog' => [
            'driver' => 'syslog',
            'level' => 'debug',
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => 'debug',
        ],
    ],

];
