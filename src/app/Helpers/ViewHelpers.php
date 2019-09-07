<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

if (!function_exists('appConfigJson')) {

    /**
     * Get app config in JSON
     *
     * This is used in the main view, to echo some intial JSON
     * config for the JS frontend to load.
     *
     * @return string Application main config in JSON form
     */
    function appConfigJson()
    {
        return json_encode([
            'token' => Request::instance()->session()->get('apiToken'),
            'apiUrl' => sprintf('https://%s/v1', env('API_DOMAIN')),
            'username' => Auth::user()->username ?? null,
            'release' => [
                'version' => getenv('RELEASE_VERSION', 'dev'),
                'timestamp' => getenv('RELEASE_TIME', null)
            ],
            'languages' => [
                'supported' => config('language.allowed'),
                'current' => App::getLocale()
            ]], JSON_UNESCAPED_UNICODE);
    }
}