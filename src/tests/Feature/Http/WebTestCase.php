<?php

namespace Tests\Feature\Http;

use Tests\TestCase;

abstract class WebTestCase extends TestCase
{

    public function getWebUrl()
    {
        return 'https://' . env('WEB_DOMAIN') . '/';
    }


    protected function setUp() : void
    {
        parent::setUp();

        $this->withHeader('Accept-Language', 'ee-ET');
    }
}
