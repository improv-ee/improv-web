<?php

namespace Tests\Feature\Auth;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RegistrationControllerTest extends TestCase
{
    use DatabaseMigrations;

    protected $userRegistrationFields = [
        'name' => 'Samantha Carter',
        'username' => 'samantha',
        'email' => 'sam@sqroot.eu',
        'password' => 'wE6h0WkhD3rLwsRO8pp7',
        'password_confirmation' => 'wE6h0WkhD3rLwsRO8pp7',
    ];

    public function testUserCanSignUp()
    {
        $response = $this->post('/register', $this->userRegistrationFields);
        $response->assertRedirect('https://localhost/admin');

        $this->assertDatabaseHas('users', ['username' => $this->userRegistrationFields['username']]);
    }

    public function testUserCanNotSignupWithTakenUsername()
    {
        $user = factory(User::class)->create();

        $fields = $this->userRegistrationFields;
        $fields['username'] = $user->username;

        $response = $this->post('/register', $fields);
        $response->assertSessionHasErrors(['username']);
    }

    public function testUserCanNotSignupWithPwnedPasswd()
    {

        $fields = $this->userRegistrationFields;
        $fields['password'] = 'monkey';
        $fields['password_confirmation'] = 'monkey';

        $response = $this->post('/register', $fields);
        $response->assertSessionHasErrors(['password']);
    }
}
