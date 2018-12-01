<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->password = Hash::make('stargate');
        $user->email = 'ando@sqroot.eu';
        $user->email_verified_at = now();
        $user->username = 'ando.roots';
        $user->name = 'Ando Roots';
        $user->save();

        factory(User::class,30)->create();
    }
}
