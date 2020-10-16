<?php

namespace Tests\Feature\Api;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Str;

/**
 * @covers \App\Http\Controllers\Api\V1\UserController
 * @package Tests\Feature\Api
 */
class UserTest extends ApiTestCase
{
    use DatabaseMigrations;

    public function testUserSearchReturnsExpectedResults()
    {
        $this->actingAsLoggedInUser();

        $user1 = User::factory()->create(['username' => 'jackblack', 'name' => 'Jack Black']);
        $user2 = User::factory()->create(['username' => 'golfer1', 'name' => 'Jack Oneill']);
        User::factory()->create();

        $response = $this->get($this->getApiUrl() . '/user/search?filter[name]=jack');
        $response->assertStatus(200)
            ->assertJson(['data' => [
                [
                    'username' => $user1->username,
                    'name' => $user1->name,
                ], [
                    'username' => $user2->username,
                    'name' => $user2->name,
                ],
            ]]);
        $response->assertJsonCount(2, 'data');
    }

    public function testDeletedUsersAreNotReturned()
    {
        $this->actingAsLoggedInUser();

        $user = User::factory()->create(['username' => 'jackblack', 'name' => 'Jack Black']);
        $user->delete();

        User::factory()->create();

        $response = $this->get($this->getApiUrl() . '/user/search?filter[name]=jack');
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function testNotFoundUserReturnsEmptySet()
    {
        $this->actingAsLoggedInUser();

        $response = $this->get($this->getApiUrl() . '/user/search?filter[name]=rosetyler');
        $response->assertStatus(200);
        $response->assertJsonCount(0, 'data');
    }

    public function testInvalidSearchQueryIsRejected()
    {
        $this->actingAsLoggedInUser();

        $query = Str::random(1000);
        $response = $this->get($this->getApiUrl() . '/user/search?filter[name]=' . $query);

        $response->assertStatus(422);
    }

    public function testEmptySearchQueryReturnsResults()
    {
        $this->actingAsLoggedInUser();
        User::factory()->count(6)->create();

        $response = $this->get($this->getApiUrl() . '/user/search?filter[name]=');

        $response->assertStatus(200);

        $this->assertGreaterThan(1, count($response->json('data')));
    }

    public function testNotLoggedInUserIsNotAuthorized()
    {

        $response = $this->get($this->getApiUrl() . '/user/search?filter[name]=test');

        $response->assertStatus(401);
    }
}
