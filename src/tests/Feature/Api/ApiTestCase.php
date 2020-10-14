<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{

    public function getApiUrl()
    {
        return 'https://' . env('API_DOMAIN') . '/v1';
    }


    protected function setUp() : void
    {
        parent::setUp();

        $this->withHeader('Accept', 'application/json');
        $this->withHeader('Accept-Language', 'ee-ET');
    }
}
