<?php

namespace Tests\Feature\Api;

use Illuminate\Support\Facades\Artisan;
use Laravel\Passport\Passport;
use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{

    public function getApiUrl()
    {
        return 'https://' . env('API_DOMAIN') . '/v1';
    }


    public function setUp()
    {
        parent::setUp();

        $this->withHeader('Accept', 'application/json');
    }
}