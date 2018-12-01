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
        'password' => 'StarGate',
        'password_confirmation' => 'StarGate',
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
}
