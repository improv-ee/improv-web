<?php

namespace Tests\Feature\Api;

use App\Orm\Event;
use App\Orm\Production;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

abstract class ApiTestCase extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->withHeader('Accept','application/json');
    }
}