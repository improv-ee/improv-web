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
        factory(User::class ,2)->create();

        // Test user
        // Not present in prod
        factory(User::class)->make([
            'username'=>'admin',
            'password'=> Hash::make('Ajutine123')
        ])->save();
    }
}
