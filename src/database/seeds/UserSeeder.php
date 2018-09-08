<?php

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
        $user = new App\User();
        $user->password = Hash::make('stargate');
        $user->email = 'ando@sqroot.eu';
        $user->email_verified_at = now();
        $user->name = 'Ando Roots';
        $user->save();

    }
}
