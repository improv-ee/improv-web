<?php

namespace Tests\Feature\Api;

use Tests\TestCase;

abstract class ApiTestCase extends TestCase
{

    public function getApiUrl()
    {
        return '/v1';
    }


    public function setUp()
    {
        parent::setUp();
        $this->withHeader('Accept', 'application/json');
    }
}