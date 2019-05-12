<?php

namespace Tests\Feature\Api;

use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @covers \App\Http\Controllers\Api\V1\TagController
 * @package Tests\Feature\Api
 */
class TagsTest extends ApiTestCase
{
    use DatabaseMigrations;


    // Can't write a test for testing tag filtering, as JSON operations are not
    // supported by sqlite https://laracasts.com/discuss/channels/eloquent/laravel-53-json-column-with-sqlite

    public function testTagListIsReturned()
    {

        $response = $this->get($this->getApiUrl() . '/tags');
        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'name' => 'töötuba',
                    'slug' => 'tootuba',
                ]
            ]]);
    }

}
