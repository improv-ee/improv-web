<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * @package Tests\Feature\Auth
 * @covers \App\Http\Controllers\Auth\RegisterController
 */
class RegistrationControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $userRegistrationFields = [
        'name' => 'Samantha Carter',
        'username' => 'samantha',
        'email' => 'sam@sqroot.eu',
        'password' => 'wE6h0WkhD3rLwsRO8pp7',
        'password_confirmation' => 'wE6h0WkhD3rLwsRO8pp7',
        'tos' => '1'
    ];

    protected function setUp() : void
    {
        parent::setUp();
        Artisan::call('passport:install');
    }


    public function testUserCanSignUp()
    {
        $response = $this->post('/register', $this->userRegistrationFields);
        $response->assertRedirect($this->getWebUrl().'/admin');

        $this->assertDatabaseHas('users', ['username' => $this->userRegistrationFields['username']]);
    }

    public function testUserCanNotSignupWithTakenUsername()
    {

        $user = User::factory()->create();

        $fields = $this->userRegistrationFields;
        $fields['username'] = $user->username;

        $response = $this->post('/register', $fields);
        $response->assertSessionHasErrors(['username']);
    }

    public function testUserCanNotSignupWithPwnedPasswd()
    {
        $fields = $this->userRegistrationFields;
        $fields['password'] = $fields['password_confirmation'] = 'password123';

        $response = $this->post('/register', $fields);

        $response->assertSessionHasErrors(['password']);
    }
}
